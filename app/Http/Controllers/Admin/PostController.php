<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Pusher\Pusher;
use App\Models\Post;
use App\Models\Notification;
use App\Models\OffendingPost;
use Carbon\Carbon;

class PostController extends Controller
{
    public $posts;

    public function load_posts()
    {
        $this->posts = Post::with('user', 'tags', 'status')
        ->withCount('comments')
        ->withCount(['interactions as likes_count' => function($query) {
            $query->select(\DB::raw("SUM(liked) as likes_count"));
        }])
        ->withCount(['interactions as views_count' => function($query) {
            $query->select(\DB::raw("SUM(views) as views_count"));
        }])
        ->get()->map(function ($post) {
            $post->is_banned = false;

            if (OffendingPost::where('post_id', $post->id)->exists()) {
                $post->is_banned = true;
            }

            return $post;
        });
    }

    public function __construct()
    {
        $this->load_posts();
    }

    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $posts = Post::where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%$keyword%")
                        ->orWhere('body', 'like', "%$keyword%");
            })
            ->with('user', 'tags', 'status')
            ->withCount('comments')
            ->withCount(['interactions as likes_count' => function($query) {
                $query->select(\DB::raw("SUM(liked) as likes_count"));
            }])
            ->withCount(['interactions as views_count' => function($query) {
                $query->select(\DB::raw("SUM(views) as views_count"));
            }])
            ->get()->map(function ($post) {
                $post->is_banned = false;
    
                if (OffendingPost::where('post_id', $post->id)->exists()) {
                    $post->is_banned = true;
                }
    
                return $post;
            });

        return response()->json([
            'posts' => $posts,
        ]);
    }

    public function ban(Request $request, $id)
    {
        $offending_post = OffendingPost::create([
            'title' => $request->input('title'),
            'reason' => $request->input('reason'),
            'post_id' => $id
        ]);

        // Tạo thông báo
        $data_notification = [
            'sender_id' => auth()->user()->id,
            'title' => 'Thông báo bài viết vi phạm',
            'type_notification' => 'offending post',
            'route' => [
                'name' => 'PostDetail',
                'params' => [
                    'id' => $id
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

        $notification = new Notification([
            'user_id' => $offending_post->post->user_id,
            'sender_id' => $data_notification['sender_id'],
            'title' => $data_notification['title'],
            'content' => 'Vi phạm nội quy',
            'type_notification' => $data_notification['type_notification'],
            'route' => $data_notification['route'],
            'read' => false,
        ]);

        $notification->save();

        $notification['user'] = $notification->user;
        $notification['sender'] = $notification->sender;

        $pusher->trigger('chanel-notification', 'event-notification-' . $notification->user_id, $notification->toArray());
        
        $this->load_posts();
        return response()->json([
            'posts' => $this->posts,
            'status' => 1,
            'message' => 'Delete post successfully.'
        ]);
    }

    public function unban(Request $request, $id)
    {
        $offending_post = OffendingPost::where('post_id', $id)->first();
        // Tạo thông báo
        $data_notification = [
            'sender_id' => auth()->user()->id,
            'title' => 'Thông báo bài viết được gỡ lệnh cấm',
            'type_notification' => 'offending post',
            'route' => [
                'name' => 'PostDetail',
                'params' => [
                    'id' => $id
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

        $notification = new Notification([
            'user_id' => $offending_post->post->user_id,
            'sender_id' => $data_notification['sender_id'],
            'title' => $data_notification['title'],
            'content' => 'Gỡ vi phạm',
            'type_notification' => $data_notification['type_notification'],
            'route' => $data_notification['route'],
            'read' => false,
        ]);

        $notification->save();

        $notification['user'] = $notification->user;
        $notification['sender'] = $notification->sender;

        $pusher->trigger('chanel-notification', 'event-notification-' . $notification->user_id, $notification->toArray());
        
        $offending_post->delete();

        $this->load_posts();
        return response()->json([
            'posts' => $this->posts,
            'status' => 1,
            'message' => 'Delete post successfully.'
        ]);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->tags()->detach();
        $post->comments()->delete();
        $post->delete();

        $this->load_posts();
        return response()->json([
            'posts' => $this->posts,
            'status' => 1,
            'message' => 'Delete post successfully.'
        ]);
    }
}
