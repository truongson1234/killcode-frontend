<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Pusher\Pusher;
use App\Models\User;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Comment;
use App\Models\Notification;

class QuestionController extends Controller
{
    public function index()
    {
        $data_query = Question::with('user', 'tags')->get();
        $questions = $data_query->map(function ($question) {
                $question->author = [
                    'id' => $question->user->id,
                    'name' => $question->user->name,
                    'email' => $question->user->email,
                    'avatar' => $question->user->avatar,
                ];
                unset($question->user);
                unset($question->user_id);
                return $question;
            });
            
        return response()->json($questions);
    }

    public function store(Request $request)
    {
        // tạo bài viết
        $question = new Question();
        // $question->user_id = 1;
        $question->user_id = auth()->user()->id;
        $question->title = $request->input('title');
        $question->body = $request->input('body');
        $question->views = $request->input('views');
        $question->likes = $request->input('likes');
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
                'name' => 'QuestionsDetail',
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
                    'content' => 'Có câu hỏi mới từ chủ đề <span class="font-bold">' . $tagNames .'</span>',
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

    public function show($id)
    {
        try {
            $question = Question::with('user', 'tags')->find($id);

            $author = $question->author = [
                'name' => $question->user->name,
                'avatar' => 'http://localhost:8000/images/' . $question->user->avatar,
                'email' => $question->user->email,
            ];
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

            return response()->json([
                'author' => $author,
                'question' => $question,
                // 'answers' => $answers,
                'comments' => $comments
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Không tồn tại câu hỏi id ' . $id,
            ]);
        }
    }

    public function update(Request $request, Question $question)
    {
        $question->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return response()->json([
            'data' => $question,
            'status' => 1,
            'message' => 'Question updated successfully.',
        ]);
    }

    public function destroy($id)
    {
        try {
            $question = Question::findOrFail($id);
            $question->tags()->detach();
            $question->comments()->delete();
            $question->delete();

            return response()->json([
                'status' => 1,
                'message' => 'Xóa thành công câu hỏi id ' . $id,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => 'Xóa thất bại câu hỏi id ' . $id,
            ]);
        }
    }
}