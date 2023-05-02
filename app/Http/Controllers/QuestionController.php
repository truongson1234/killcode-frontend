<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Pusher\Pusher;
use App\Models\User;
use App\Models\Answer;
use App\Models\Comment;
use App\Models\QuestionInteraction;
use App\Models\Question;
use App\Models\Tag;
use App\Models\Notification;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with('user', 'tags')->withCount('comments')
        ->withCount(['interactions as likes_count' => function($query) {
            $query->select(\DB::raw("SUM(liked) as likes_count"));
        }])
        ->withCount(['interactions as views_count' => function($query) {
            $query->select(\DB::raw("SUM(views) as views_count"));
        }])
        ->orderBy('created_at', 'desc')->where('status_id', 1)->get();
        $questions = $questions->map(function ($question) {
                $question->author = [
                    'id' => $question->user->id,
                    'name' => $question->user->name,
                    'email' => $question->user->email,
                    'avatar' => $question->user->avatar,
                ];
                unset($question->user);
                return $question;
            });
        $popular_tags = Tag::withCount('questions')->orderBy('questions_count', 'desc')->take(5)->get();
        if(auth()->user()) {
            $followedTags = User::findOrFail(auth()->user()->id)->tags()->pluck('tags.id');
            $relatedQuestions = Question::whereHas('tags', function($query) use ($followedTags) {
                $query->whereIn('tags.id', $followedTags);
            })->get();
            $relatedQuestions = $relatedQuestions->map(function($post) {
                $post->author = [
                    'id' => $post->user->id,
                    'name' => $post->user->name,
                    'email' => $post->user->email,
                    'avatar' => $post->user->avatar,
                ];
                unset($post->user);
                return $post;
            });
        }else {
            $relatedQuestions = [];
        }
        $newQuestions = Question::where('status_id', 1)->with('user')->withCount('comments')
        ->withCount(['interactions as likes_count' => function($query) {
            $query->select(\DB::raw("SUM(liked) as likes_count"));
        }])
        ->withCount(['interactions as views_count' => function($query) {
            $query->select(\DB::raw("SUM(views) as views_count"));
        }])->orderBy('created_at', 'desc')->take(5)->get();
        $newQuestions = $newQuestions->map(function ($question) {
            $question->author = [
                'id' => $question->user->id,
                'name' => $question->user->name,
                'email' => $question->user->email,
                'avatar' => $question->user->avatar,
            ];
            unset($question->user);
            return $question;
        });
        $popularQuestions = Question::withCount('comments')
            ->withCount(['interactions as likes_count' => function($query) {
                $query->select(\DB::raw("SUM(liked) as likes_count"));
            }])
            ->withCount(['interactions as views_count' => function($query) {
                $query->select(\DB::raw("SUM(views) as views_count"));
            }])
            ->orderByRaw('(views_count + likes_count) DESC')
            ->orderBy('comments_count', 'DESC')
            ->orderByDesc('comments_count')
            ->limit(5) // Lấy ra 10 câu hỏi phổ biến nhất
            ->get();
        $popularQuestions = $popularQuestions->map(function ($question) {
            $question->author = [
                'id' => $question->user->id,
                'name' => $question->user->name,
                'email' => $question->user->email,
                'avatar' => $question->user->avatar,
            ];
            unset($question->user);
            return $question;
        });    
        return response()->json([
            'data' => $questions,
            'related_questions' => $relatedQuestions,
            'new_questions' => $newQuestions,
            'popular_tags' => $popular_tags,
            'popular_questions' => $popularQuestions
        ]);
    }

    public function store(Request $request)
    {
        // tạo bài viết
        $question = new Question();
        // $question->user_id = 1;
        $question->user_id = auth()->user()->id;
        $question->title = $request->input('title');
        $question->body = $request->input('body');
        $question->status_id = 1;
        $question->save();

        // tạo followed tag
        $tagIds = $request->input('tag_ids');

        $question->tags()->attach($tagIds);

        // Tạo thông báo
        $data_notification = [
            'sender_id' => $question->user_id,
            'title' => 'Thông báo có câu hỏi mới',
            'type_notification' => 'new question',
            'route' => [
                'name' => 'QuestionDetail',
                'params' => [
                    'id' => $question->id
                ]
            ]
        ];

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'encrypted' => true
            ]
        );

        // lấy tất cả các user đã follow các tag trong post
        $users = User::whereIn('id', function($query) use($tagIds) {
            $query->select('user_id')
                ->from('followed_tags')
                ->whereIn('tag_id', $tagIds);
        })->with('tags')->get();

        if ($users->count()) {
            // gửi thông báo tới user đang follow tag trong post
            foreach ($users as $user) {
                $tagNames = $user->tags->whereIn('id', $tagIds)
                    ->take(3)
                    ->pluck('name')
                    ->implode(', ');

                $notification = new Notification([
                    'user_id' => $user->id,
                    'sender_id' => $data_notification['sender_id'],
                    'title' => $data_notification['title'],
                    // 'content' => 'Có câu hỏi mới từ ' . $tagNames . '. Tựa đề: ' . $question->title,
                    'content' => 'Có câu hỏi mới từ chủ đề <span class="font-bold">' . $tagNames .'.</span>',
                    'type_notification' => $data_notification['type_notification'],
                    'route' => $data_notification['route'],
                    'read' => false,
                ]);
    
                $notification->save();

                $notification['user'] = $notification->user;
                $notification['sender'] = $notification->sender;

                $pusher->trigger('chanel-notification', 'event-notification-' . $user->id, $notification);
            }
        }            

        return response()->json([
            'data' => $question,
            'message' => 'Question created successfully.',
        ], 201);
    }
    public function draftQuestion(Request $request)
    {
        // tạo bài viết
        $question = new Question();
        // $question->user_id = 1;
        $question->user_id = auth()->user()->id;
        $question->title = $request->input('title');
        $question->body = $request->input('body');
        $question->status_id = 2;
        $question->save();

        // tạo followed tag
        $tagIds = $request->input('tag_ids');

        $question->tags()->attach($tagIds);

        // Tạo thông báo
        $data_notification = [
            'sender_id' => $question->user_id,
            'title' => 'Thông báo có câu hỏi mới',
            'type_notification' => 'new question',
            'route' => [
                'name' => 'QuestionDetail',
                'params' => [
                    'id' => $question->id
                ]
            ]
        ];

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'encrypted' => true
            ]
        );

        // lấy tất cả các user đã follow các tag trong post
        $users = User::whereIn('id', function($query) use($tagIds) {
            $query->select('user_id')
                ->from('followed_tags')
                ->whereIn('tag_id', $tagIds);
        })->with('tags')->get();

        if ($users->count()) {
            // gửi thông báo tới user đang follow tag trong post
            foreach ($users as $user) {
                $tagNames = $user->tags->whereIn('id', $tagIds)
                    ->take(3)
                    ->pluck('name')
                    ->implode(', ');

                $notification = new Notification([
                    'user_id' => $user->id,
                    'sender_id' => $data_notification['sender_id'],
                    'title' => $data_notification['title'],
                    // 'content' => 'Có câu hỏi mới từ ' . $tagNames . '. Tựa đề: ' . $question->title,
                    'content' => 'Có câu hỏi mới từ chủ đề <span class="font-bold">' . $tagNames .'.</span>',
                    'type_notification' => $data_notification['type_notification'],
                    'route' => $data_notification['route'],
                    'read' => false,
                ]);
    
                $notification->save();

                $notification['user'] = $notification->user;
                $notification['sender'] = $notification->sender;

                $pusher->trigger('chanel-notification', 'event-notification-' . $user->id, $notification);
            }
        }            

        return response()->json([
            'data' => $question,
            'message' => 'Question created successfully.',
        ], 201);
    }

    public function getQuestionByUser($id) {
        $data_query = Question::where('user_id', $id)->with('user', 'tags')->orderBy('created_at', 'desc')->where('status_id', 1)->get();
        $questions = $data_query->map(function ($question) {
            $question->author = [
                'id' => $question->user->id,
                'name' => $question->user->name,
                'email' => $question->user->email,
                'avatar' => $question->user->avatar,
            ];
            unset($question->user);
            return $question;
        });
        return response()->json([
            'questions' => $questions,
        ]);
    }
    public function getDraftQuestionByUser($id) 
    {
        $user = User::findOrFail($id);
        $questions = Question::where('user_id', $id)->where('status_id', 2)->with('tags')->orderBy('created_at', 'desc')->get();
        return response()->json(['data' => $questions]);
    }

    public function updateDraftQuestion(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        $question->update([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'updated_at' => now()
        ]);

        $tagIds = $request->input('tag_ids');
        $question->tags()->detach();
        $question->tags()->attach($tagIds);
        return response()->json([
            'data' => $question,
            'status' => 1,
            'message' => 'Cập nhật bản nháp thành công.'
        ]);
    }

    public function show($id)
    {
        $question = Question::withCount('comments')
            ->withCount(['interactions as likes_count' => function($query) {
                $query->select(\DB::raw("SUM(liked) as likes_count"));
            }])
            ->withCount(['interactions as views_count' => function($query) {
                $query->select(\DB::raw("SUM(views) as views_count"));
            }])->findOrFail($id);

        $viewers = [];
        if(auth()->user()) {
            $interaction = QuestionInteraction::where('user_id', auth()->user()->id)->where('question_id', $id);
            $liked = $interaction->exists() ? $interaction->first()->liked : 0;

        }else {
            $liked = 0;
        }

        if (Question::find($id)->interactions()->exists()) {
            $viewers = $question->interactions->map(function ($viewer) {
                $viewer->person = [
                    'name' => $viewer->user->name,
                    'avatar' => $viewer->user->avatar,
                ];

                unset($viewer->user);

                return $viewer;
            });
        }
        $comments = Comment::with('user')
        ->select('id', 'content', 'parent_id', 'post_id', 'user_id', 'created_at', 'updated_at')
        ->where('post_id', $id)
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get()
        ->map(function ($comment) {
            $comment->author = [
                'id' => $comment->user->id,
                'name' => $comment->user->name,
                'email' => $comment->user->email,
                'avatar' => $comment->user->avatar,
            ];
            unset($comment->user);
            return $comment;
        });
        $author = User::findOrFail($question->user_id);
        $author->avatar = 'http://localhost:8000/images/'. $author->avatar;
        $tags = Tag::select('tags.*')
            ->join('question_tag', 'question_tag.tag_id', '=', 'tags.id')
            ->where('question_tag.question_id', $question->id)
            ->get();
        // $answers = $question->answers
        //                     ->take(5)
        //                     ->each(function ($item, $key) {
        //                         $item->person = [
        //                             'name' => $item->user->name,
        //                             'avatar' => 'http://localhost:8000/images/' . $item->user->avatar,
        //                             'email' => $item->user->email
        //                         ];
        //                         unset($item->user);
        //                     });

        // unset($question->user);
        // unset($question->answers);
        // Lấy ra các bài viết liên quan đến post 
        $currentQuestion = Question::with('tags')->findOrFail($id)->tags->map(function($tag) {
                            $tag->id = $tag->pivot->tag_id;
                            unset($tag->name);
                            unset($tag->slug);
                            unset($tag->pivot);
                            return $tag;
                        });
        $relatedQuestions = Question::where('id', '<>', $id)->where('status_id', 1)->whereHas('tags', function($query) use ($currentQuestion) {
            $query->whereIn('tags.id', $currentQuestion);
        })->with('tags')->withCount('comments')->withCount(['interactions as likes_count' => function($query) {
            $query->select(\DB::raw("SUM(liked) as likes_count"));
        }])
        ->withCount(['interactions as views_count' => function($query) {
            $query->select(\DB::raw("SUM(views) as views_count"));
        }])->take(5)->get();
        $relatedQuestions = $relatedQuestions->map(function($question) {
            $question->author = [
                'id' => $question->user->id,
                'name' => $question->user->name,
                'email' => $question->user->email,
                'avatar' => $question->user->avatar,
            ];
            unset($question->user);
            unset($question->interactions);
            return $question;
        });
        return response()->json([
            'question' => $question,
            'liked' => $liked,
            'viewers' => $viewers,
            'tags' => $tags,
            'author' => $author,
            'comments' => $comments,
            'related_questions' => $relatedQuestions
        ]);
    }

    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);

        if($question->status_id == 2) {
            $question->update([
                'title' => $request->input('title'),
                'body' => $request->input('body'),
                'updated_at' => now(),
                'status_id' => 1,
            ]);
        }else {
            $question->update([
                'title' => $request->input('title'),
                'body' => $request->input('body'),
                'updated_at' => now()
            ]);
        }
        $tagIds = $request->input('tag_ids');
        $question->tags()->detach();
        $question->tags()->attach($tagIds);
        return response()->json([
            'data' => $question,
            'status' => 1,
            'message' => 'Question updated successfully.',
        ]);
    }

    public function searchDraftQuestion(Request $request, $id) {
        $keyword = $request->input('title');
        $type =  $request->input('type');
        if($type == 'draft') {
            $draftQuestions = Question::where('title', 'like', "%$keyword%")
                                ->where('user_id', $id)->where('status_id', 2)
                                ->with('tags')->orderBy('updated_at', 'desc')->get();
            return response()->json(['data' => $draftQuestions]);
        }
        if($type == 'public') {
            $publicQuestions = Question::where('title', 'like', "%$keyword%")
                                ->where('user_id', $id)->where('status_id', 1)
                                ->with('tags')->orderBy('updated_at', 'desc')->get();
            return response()->json(['data' => $publicQuestions]);
        }
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->tags()->detach();
        $question->comments()->delete();
        $question->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Xóa thành công câu hỏi id ' . $id,
        ]);
    }
}