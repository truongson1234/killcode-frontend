<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Tag;
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
        $data_query = Post::with('user', 'tags')->get();
        $posts = $data_query->map(function ($post) {
                $post->author = [
                    'name' => $post->user->name,
                    'email' => $post->user->email,
                    'avatar' => $post->user->avatar,
                ];
                unset($post->user);
                return $post;
            });
            
        return response()->json([
            'data' => $posts
        ]);
    }

    public function show($id)
    {
        $post = Post::select('id', 'title', 'body', 'views', 'likes', 'created_at', 'updated_at', 'user_id')
            ->findOrFail($id);

        $comments = Comment::with('user')
            ->select('id', 'content', 'parent_id', 'post_id', 'user_id', 'created_at', 'updated_at')
            ->where('post_id', $id)
            ->orderBy('created_at', 'desc')
            ->take(5) // Giới hạn số lượng bản ghi comments chỉ lấy 5 bản mới nhất
            ->get()
            ->map(function ($comment) {
                $comment->author = [
                    'name' => $comment->user->name,
                    'email' => $comment->user->avatar,
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
        return response()->json([
            'post' => $post,
            'comments' => $comments,
            'author' => $author,
            'tags' => $tags
        ]);
    }

    public function getPostByUser($id) {
        $data_query = Post::where('user_id', $id)->with('user', 'tags')->get();
        $posts = $data_query->map(function ($post) {
            $post->author = [
                'name' => $post->user->name,
                'email' => $post->user->email,
                'avatar' => $post->user->avatar,
            ];
            unset($post->user);
            return $post;
        });
        return response()->json([
            'posts' => $posts,
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
            $post->views = $request->input('views');
            $post->likes = $request->input('likes');
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
                    'name' => 'PostsDetail',
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
                        'content' => 'Có bài viết mới từ chủ đề <span class="font-bold">' . $tagNames .'</span>',
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

    public function like(Request $request)
    {
        
    }

    public function unlike(Request $request)
    {
        
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
