<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
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
        $currentPage = $request->input('page', 1);
        $perPage = $request->input('perPage', 3);

        $paginator = Post::with('user')->paginate($perPage);
        $posts = collect($paginator->items())
            ->map(function ($post) {
                $post->author = [
                    'name' => $post->user->name,
                    'email' => $post->user->email,
                ];
                unset($post->user);
                return $post;
            });

        return response()->json([
            'currentPage' => $paginator->currentPage(),
            'totalPages' => $paginator->lastPage(),
            'data' => $posts->all()
        ]);
    }

    public function show($id)
    {
        $post = Post::select('id', 'title', 'body', 'views', 'likes', 'created_at', 'updated_at')
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

        return response()->json([
            'post' => $post,
            'comments' => $comments,
        ]);
    }


    public function store(Request $request)
    {
        try {
            // tạo bài viết
            $post = new Post();
            // $post->user_id = 2;
            $post->user_id = auth()->user()->id;
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
                'title' => 'Thông báo có bài viết mới!',
                'content' => $post->title,
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
            })->get();

            // gửi thông báo tới user đang follow tag trong post
            foreach ($users as $user) {
                $pusher->trigger('chanel-notification', 'event-notification-' . $user->id, $data_notification);
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
        $post->update($request->all());

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
        $post->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Delete post successfully.'
        ], 204);
    }
}
