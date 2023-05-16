<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Post;
use App\Models\Question;
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
            if (auth()->user()->hasPermissionTo('write-comment')) {
                if($request->input('post_id')) {

                    $post = Post::findOrFail($request->input('post_id'));
        
                    if ($request->input('parent_id')) {
                        $parentComment = Comment::findOrFail($request->input('parent_id'));
                        $comment = new Comment();
                        $comment->parent_id = $parentComment->id;
                        $comment->post_id = $post->id;
                        $comment->user_id = auth()->user()->id;
                        // $comment->user_id = 1;
                        $comment->content = $request->input('content');
                
                    } else {
                        $comment = new Comment();
                        $comment->post_id = $post->id;
                        $comment->user_id = auth()->user()->id;
                        // $comment->user_id = 1;
                        $comment->content = $request->input('content');
                    }
        
                    $comment->save();
        
                    $comment->author = [
                        'id' => $comment->user->id,
                        'name' => $comment->user->name,
                        'avatar' => $comment->user->avatar,
                        'email' => $comment->user->email,
                    ];
                    unset($comment->user);
                    // Tạo thông báo
                    $data_notification = [
                        'title' => 'Thông báo có bình luận mới',
                        'type_notification' => 'comment',
                        'route' => [
                            'name' => 'PostDetail',
                            'params' => [
                                'id' => $comment->post_id
                            ]
                        ]
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
                                'content' => '<span class="font-bold">' . $comment->author['name'] . '</span> đã bình luận bài viết bạn đang theo dõi.',
                                'type_notification' => $data_notification['type_notification'],
                                'route' => $data_notification['route'],
                                'read' => false,
                            ]);
                            
                            $notification->save();
        
                            $notification['user'] = $notification->user;
                            $notification['sender'] = $notification->sender;
                            // dd($notification->toArray());
                            $pusher->trigger('chanel-notification', 'event-notification-' . $notification->user_id, $notification->toArray());
                        }
                    }
        
                    if ($post->user_id !== $comment->user_id) {
                        $notification = new Notification([
                            'user_id' => $post->user_id,
                            'sender_id' => $comment->user_id,
                            'title' => $data_notification['title'],
                            'content' => '<span class="font-bold" href="#">' . $comment->author['name'] . '</span> đã bình luận bài viết của bạn.',
                            'type_notification' => $data_notification['type_notification'],
                            'route' => $data_notification['route'],
                            'read' => false,
                        ]);
                        
                        $notification->save();
                        
                        $notification['user'] = $notification->user;
                        $notification['sender'] = $notification->sender;
        
                        $pusher->trigger('chanel-notification', 'event-notification-' . $notification->user_id, $notification->toArray());
                    }
        
                    // Gửi bình luận tới bài viết
                    $pusher->trigger('chanel-comments', 'event-comment-' . $comment->post_id, $comment);
         
                    return response()->json([
                        'data' => $comment,
                        'status' => 1,
                        'message' => 'Đã bình luận.'
                    ], 201);
                }else {
                    $question = Question::findOrFail($request->input('question_id'));
        
                    if ($request->input('parent_id')) {
                        $parentComment = Comment::findOrFail($request->input('parent_id'));
                        $comment = new Comment();
                        $comment->parent_id = $parentComment->id;
                        $comment->post_id = $question->id;
                        $comment->user_id = auth()->user()->id;
                        // $comment->user_id = 1;
                        $comment->content = $request->input('content');
                
                    } else {
                        $comment = new Comment();
                        $comment->post_id = $question->id;
                        $comment->user_id = auth()->user()->id;
                        // $comment->user_id = 1;
                        $comment->content = $request->input('content');
                    }
        
                    $comment->save();
        
                    $comment->author = [
                        'id' => $comment->user->id,
                        'name' => $comment->user->name,
                        'email' => $comment->user->email,
                        'avatar' => $comment->user->avatar,
                    ];
                    unset($comment->user);
                    // Tạo thông báo
                    $data_notification = [
                        'title' => 'Thông báo có bình luận mới',
                        'type_notification' => 'comment',
                        'route' => [
                            'name' => 'QuestionDetail',
                            'params' => [
                                'id' => $comment->post_id
                            ]
                        ]
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
                        ->where('user_id', '<>', $question->user_id)
                        ->groupBy('user_id')
                        ->get();
                    
        
                    // Gửi cho các user đã bình luận bài viết
                    if ($previousComments->count()) {
                        foreach ($previousComments as $previousComment) {
                            $notification = new Notification([
                                'user_id' => $previousComment->user_id,
                                'sender_id' => $comment->user_id,
                                'title' => $data_notification['title'],
                                'content' => '<span class="font-bold">' . $comment->author['name'] . '</span> đã bình luận câu hỏi bạn đang theo dõi.',
                                'type_notification' => $data_notification['type_notification'],
                                'route' => $data_notification['route'],
                                'read' => false,
                            ]);
                            
                            $notification->save();
        
                            $notification['user'] = $notification->user;
                            $notification['sender'] = $notification->sender;
                            // dd($notification->toArray());
                            $pusher->trigger('chanel-notification', 'event-notification-' . $notification->user_id, $notification->toArray());
                        }
                    }
        
                    if ($question->user_id !== $comment->user_id) {
                        $notification = new Notification([
                            'user_id' => $question->user_id,
                            'sender_id' => $comment->user_id,
                            'title' => $data_notification['title'],
                            'content' => '<span class="font-bold" href="#">' . $comment->author['name'] . '</span> đã bình luận câu hỏi của bạn.',
                            'type_notification' => $data_notification['type_notification'],
                            'route' => $data_notification['route'],
                            'read' => false,
                        ]);
                        
                        $notification->save();
                        
                        $notification['user'] = $notification->user;
                        $notification['sender'] = $notification->sender;
        
                        $pusher->trigger('chanel-notification', 'event-notification-' . $notification->user_id, $notification->toArray());
                    }
        
                    // Gửi bình luận tới bài viết
                    $pusher->trigger('chanel-comments', 'event-comment-' . $comment->post_id, $comment);
         
                    return response()->json([
                        'data' => $comment,
                        'status' => 1,
                        'message' => 'Đã bình luận.'
                    ], 201);
                }
            } else {
                return response()->json([
                    'data' => [],
                    'status' => 0,
                    'message' => 'Bạn không có quyền bình luận bài viết!'
                ]);
            }
        } catch (ApiErrorException $exception) {
            return response()->json([
                'data' => [],
                'status' => 0,
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function update(Comment $comment, Request $request)
    {
        if (auth()->user()->hasPermissionTo('edit-comment')) {
            if ($comment->user_id != auth()->user()->id) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
    
            $comment->update([
                'content' => $request->input('content')
            ]);
    
            return response()->json($comment);
        } else {
            return response()->json([
                'data' => [],
                'status' => 0,
                'message' => 'Bạn không có quyền sửa bình luận bài viết!'
            ]);
        }
    }

    public function destroy(Comment $comment)
    {
        if (auth()->user()->hasPermissionTo('delete-comment')) {
            if ($comment->user_id != auth()->user()->id) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
    
            $comment->delete();
    
            return response()->json(['message' => 'Comment deleted successfully']);
        } else {
            return response()->json([
                'data' => [],
                'status' => 0,
                'message' => 'Bạn không có quyền xóa bình luận bài viết!'
            ]);
        }
    }
}

