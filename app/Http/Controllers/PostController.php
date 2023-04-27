<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\Interaction;
use App\Models\Notification;
use Pusher\Pusher;
use Pusher\PusherException;
use Pusher\ApiErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $data_query = Post::with('user', 'tags')
            ->withCount('comments')
            ->withCount(['interactions as likes_count' => function($query) {
                $query->select(\DB::raw("SUM(liked) as likes_count"));
            }])
            ->withCount(['interactions as views_count' => function($query) {
                $query->select(\DB::raw("SUM(views) as views_count"));
            }])
            ->get();
            
        $posts = $data_query->map(function ($post) {
                $post->author = [
                    'id' => $post->user->id,
                    'name' => $post->user->name,
                    'email' => $post->user->email,
                    'avatar' => 'http://localhost:8000/images/' . $post->user->avatar,
                ];
                unset($post->user);
                return $post;
            });
        $popular_tags = Tag::withCount('posts')->orderBy('posts_count', 'desc')->take(5)->get();
        if(auth()->user()) {
            $followedTags = User::findOrFail(auth()->user()->id)->tags()->pluck('tags.id');
            $relatedPosts = Post::whereHas('tags', function($query) use ($followedTags) {
                $query->whereIn('tags.id', $followedTags);
            })->get();
            $relatedPosts = $relatedPosts->map(function($post) {
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
            $relatedPosts = [];
        }
        $newPosts = Post::with('user')->withCount(['interactions as likes_count' => function($query) {
                        $query->select(\DB::raw("SUM(liked) as likes_count"));
                    }])
                    ->withCount(['interactions as views_count' => function($query) {
                        $query->select(\DB::raw("SUM(views) as views_count"));
                    }])->orderBy('created_at', 'desc')->take(5)->get();
        $newPosts = $newPosts->map(function ($post) {
            $post->author = [
                'id' => $post->user->id,
                'name' => $post->user->name,
                'email' => $post->user->email,
                'avatar' => $post->user->avatar,
            ];
            unset($post->user);
            return $post;
        });

        return response()->json([
            'data' => $posts,
            'popular_tags' => $popular_tags,
            'related_posts' => $relatedPosts,
            'new_posts' => $newPosts
        ]);
    }

    public function show($id)
    {
        $post = Post::withCount('comments')
            ->withCount(['interactions as likes_count' => function($query) {
                $query->select(\DB::raw("SUM(liked) as likes_count"));
            }])
            ->withCount(['interactions as views_count' => function($query) {
                $query->select(\DB::raw("SUM(views) as views_count"));
            }])->findOrFail($id);

        $viewers = [];
        if(auth()->user()) {
            $interaction = Interaction::where('user_id', auth()->user()->id)->where('post_id', $id);
            $liked = $interaction->exists() ? $interaction->first()->liked : 0;
        }else {
            $liked = 0;
        }

        if (Post::find($id)->interactions()->exists()) {
            $viewers = $post->interactions->map(function ($viewer) {
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
            ->take(5) // Giới hạn số lượng bản ghi comments chỉ lấy 5 bản mới nhất
            ->get()
            ->map(function ($comment) {
                $comment->author = [
                    'id' => $comment->user->id,
                    'name' => $comment->user->name,
                    'avatar' => $comment->user->avatar,
                    'email' => $comment->user->email,
                ];
                unset($comment->user);
                return $comment;
            });
        $author = User::findOrFail($post->user_id);
        $author->avatar = 'http://localhost:8000/images/'. $author->avatar;

        $tags = Tag::select('tags.*')
                ->join('post_tag', 'post_tag.tag_id', '=', 'tags.id')
                ->where('post_tag.post_id', $post->id)
                ->get();
        
        // Lấy ra các bài viết liên quan đến post 
        $currentPost = Post::with('tags')->findOrFail($id)->tags->map(function($tag) {
                    $tag->id = $tag->pivot->tag_id;
                    unset($tag->name);
                    unset($tag->slug);
                    unset($tag->pivot);
                    return $tag;
                });
        $relatedPosts = Post::where('id', '<>', $id)->whereHas('tags', function($query) use ($currentPost) {
                            $query->whereIn('tags.id', $currentPost);
                            })->with('tags')->withCount('comments')->withCount(['interactions as likes_count' => function($query) {
                            $query->select(\DB::raw("SUM(liked) as likes_count"));
                            }])
                            ->withCount(['interactions as views_count' => function($query) {
                            $query->select(\DB::raw("SUM(views) as views_count"));
                            }])->take(5)->get();
        $relatedPosts = $relatedPosts->map(function($post) {
            $post->author = [
            'id' => $post->user->id,
            'name' => $post->user->name,
            'email' => $post->user->email,
            'avatar' => $post->user->avatar,
            ];
            unset($post->user);
            unset($post->interactions);
            return $post;
        });
        return response()->json([
            'post' => $post,
            'liked' => $liked,
            'viewers' => $viewers,
            'comments' => $comments,
            'author' => $author,
            'tags' => $tags,
            'related_posts' => $relatedPosts
        ]);
    }

    public function getPostByUser($id) {
        $data_query = Post::where('user_id', $id)->with('user', 'tags')->get();
        $user = User::findOrFail($id);
        $posts = $data_query->map(function ($post) {
            $post->author = [
                'id' => $post->user->id,
                'name' => $post->user->name,
                'email' => $post->user->email,
                'avatar' => $post->user->avatar,
            ];
            unset($post->user);
            return $post;
        });
        return response()->json([
            'posts' => $posts,
            'user' => $user,
        ]);
    }

    public function store(Request $request)
    {
        try {
            // tạo bài viết
            $post = new Post();
            $post->user_id = 1;
            // $post->user_id = auth()->user()->id;
            $post->title = $request->input('title');
            $post->body = $request->input('body');
            $post->status_id = 1;
            $post->save();

            // tạo followed tag
            $tagIds = $request->input('tag_ids');

            $post->tags()->attach($tagIds);

            // Tạo thông báo
            $data_notification = [
                'sender_id' => $post->user_id,
                'title' => 'Thông báo có bài viết mới',
                'type_notification' => 'new post',
                'route' => [
                    'name' => 'PostDetail',
                    'params' => [
                        'id' => $post->id
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
                        // 'content' => 'Có bài viết mới từ ' . $tagNames . '. Tựa đề: ' . $post->title,
                        'content' => 'Có bài viết mới từ chủ đề <span class="font-bold">' . $tagNames .'.</span>',
                        'type_notification' => $data_notification['type_notification'],
                        'route' => $data_notification['route'],
                        'read' => false,
                    ]);
        
                    $notification->save();

                    $notification['user'] = $notification->user;
                    $notification['sender'] = $notification->sender;

                    $pusher->trigger('chanel-notification', 'event-notification-' . $user->id, $notification->toArray());
                }
            }            

            return response()->json([
                'data' => $post,
                'status' => 1,
                'message' => 'Tạo thành công.'
            ], 201);

        } catch (ApiErrorException $exception) {
            return response()->json([
                'data' => [],
                'status' => 0,
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        // Update post data in database
        $post = Post::findOrFail($id);
        // $post->update($request->all());
        $post->update([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
        ]);
        // tạo followed tag
        $tagIds = $request->input('tag_ids');
        $post->tags()->detach();
        $post->tags()->attach($tagIds);
        // Return updated post data
        return response()->json([
            'data' => $post,
            'status' => 1,
            'message' => 'Cập nhật thành công.'
        ]);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->tags()->detach();
        $post->comments()->delete();
        $post->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Delete post successfully.'
        ], 204);
    }
}
