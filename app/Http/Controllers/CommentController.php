<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
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
                // $comment->user_id = 2;
                $comment->content = $request->input('content');
        
            } else {
                $comment = new Comment();
                $comment->post_id = $post->id;
                $comment->user_id = auth()->user()->id;
                // $comment->user_id = 2;
                $comment->content = $request->input('content');
            }

            $comment->save();

            $comment->author = [
                'name' => $comment->user->name,
                'email' => $comment->user->email,
            ];
            unset($comment->user);
            // Tạo thông báo
            $data_notification = [
                'title' => $post->title ,
                'content' => $comment->content,
                'type_notification' => 'comment',
                'post_id' => $comment->post_id,
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

            $previousComments = Comment::select('user_id')
                ->where('post_id', $comment->post_id)
                ->where('user_id', '<>', $comment->user_id)
                ->where('user_id', '<>', $post->user_id)
                ->groupBy('user_id')
                ->get();
            

            // Gửi cho các user đã bình luận bài viết
            if ($previousComments->count()) {
                foreach ($previousComments as $previousComment) {
                    $notification = new Notification([
                        'user_id' => $previousComment->user_id,
                        'sender_id' => $comment->user_id,
                        'title' => $data_notification['title'],
                        'content' => $data_notification['content'],
                        'type_notification' => $data_notification['type_notification'],
                        'post_id' => $data_notification['post_id'],
                        'read' => false,
                    ]);
                    
                    $notification->save();

                    $data_notification['read'] = $notification->read;

                    $data_notification['sender'] = [
                        'name' => $notification->sender->name,
                        'avatar' => $notification->sender->avatar,
                    ];
                    $data_notification['created_at'] = $notification->created_at;
    
                    $pusher->trigger('chanel-notification', 'event-notification-' . $notification->user_id, $data_notification);
                }
            }

            if ($post->user_id) {
                $notification = new Notification([
                    'user_id' => $post->user_id,
                    'sender_id' => $comment->user_id,
                    'title' => $data_notification['title'],
                    'content' => $data_notification['content'],
                    'type_notification' => $data_notification['type_notification'],
                    'post_id' => $data_notification['post_id'],
                    'read' => false,
                ]);
                
                $notification->save();

                $data_notification['read'] = $notification->read;

                $data_notification['sender'] = [
                    'name' => $notification->sender->name,
                    'avatar' => $notification->sender->avatar,
                ];
                $data_notification['created_at'] = $notification->created_at;

                $pusher->trigger('chanel-notification', 'event-notification-' . $notification->user_id, $data_notification);
            }


            // Gửi bình luận tới bài viết
            $pusher->trigger('chanel-comments', 'event-comment-' . $comment->post_id, $comment);

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

