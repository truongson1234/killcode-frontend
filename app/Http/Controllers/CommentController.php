<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Notification;
use Pusher\Pusher;
use Pusher\PusherException;
use Pusher\ApiErrorException;

class CommentController extends Controller
{
    public function index()
    {
        
    }

    public function store(Request $request)
    {
        try {
            $post = Post::findOrFail($request->input('post_id'));

            if ($request->input('parent_id')) {
                $parentComment = Comment::findOrFail($request->input('parent_id'));
                $comment = new Comment();
                $comment->parent_id = $parentComment->id;
                $comment->post_id = $post->id;
                $comment->user_id = auth()->user()->id;
                $comment->content = $request->input('content');
        
            } else {
                $comment = new Comment();
                $comment->post_id = $post->id;
                $comment->user_id = auth()->user()->id;
                $comment->content = $request->input('content');
            }

            $comment->save();

            $comment->author = [
                'name' => $comment->user->name,
                'email' => $comment->user->avatar,
            ];
            unset($comment->user);

            // Tạo thông báo
            $data_notification = [
                'title' => 'Bình luận từ bài viết "' . $post->title . '"',
                'content' => 'Nội dung: "' . $request->input('content') . '"',
            ];
            
            
            // Gửi thông báo
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                [
                    'cluster' => env('PUSHER_APP_CLUSTER'),
                    'useTLS' => true,
                ]
            );

            $previousComments = Comment::where('post_id', $post->id)->where('id', '<>', $comment->id)->get();
            $notifiedUserIds = [];

            // Gửi cho các user đã bình luận bài viết "post_id"
            foreach ($previousComments as $previousComment) {
                // ĐK1: người bình luận trước !== người đang bình luận
                // => gửi thông báo cho người đã bình luận trước đó nhưng không gửi lại cho người đang thông báo
                // ĐK2: để trách gửi thông báo nhiều lần cho 1 user
                if ($previousComment->user_id !== $comment->user_id && $previousComment->user_id !== $post->user_id && !in_array($previousComment->user_id, $notifiedUserIds)) {
                    $notifiedUserIds[] = $previousComment->user_id; // Thêm ID người dùng vào mảng tạm

                    $notification = new Notification([
                        'user_id' => $previousComment->user_id,
                        'title' => $data_notification['title'],
                        'content' => $data_notification['content'],
                        'read' => false,
                    ]);
        
                    $notification->save();

                    $pusher->trigger('chanel-notification', 'event-notification-' . $previousComment->user_id, $data_notification);
                }
            }
            
            //người đăng bài !== người đang bình luận 
            // => gửi thông báo cho người đăng bài nếu người đăng bài bình luận sẽ không gửi thông báo
            if ($post->user_id !== $comment->user_id) {
                $pusher->trigger('chanel-notification', 'event-notification-' . $post->user_id, $data_notification);
            }


            // Gửi bình luận tới bài viết
            $pusher->trigger('chanel-comments', 'event-comment-' . $post->id, $comment);

            return response()->json([
                'data' => $comment,
                'status' => 1,
                'message' => 'Đã bình luận.'
            ], 201);

        } catch (ApiErrorException $exception) {
            return response()->json([
                'data' => [],
                'status' => 0,
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function update(Request $request)
    {
        if ($comment->user_id != auth()->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->save();

        return response()->json($comment);
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id != auth()->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }
}

