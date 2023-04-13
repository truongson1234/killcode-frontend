<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Pusher\Pusher;
use App\Models\User;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function getUser(Request $request)
    {
        try {
            $user = User::findOrFail($request->input('user_id'));

            $notifications = $user->notifications()
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            return response()->json([
                'status' => 1,
                'data' => $notifications,
                'message' => 'Lấy ra thông báo của ' . $user->name . '.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'data' => $th,
                'message' => 'Đã có lỗi xảy ra.'
            ]);
        }
    }

    public function readNotice($id) {
        try {
            $notice = Notification::findOrFail($id);
            $notice->update(['read' => true]);
            return response()->json(['msg' => 'Đọc thành công'], 204);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 402);
        }
    }
    public function readAllNotice($user_id) {
        try {
            $notices = Notification::where('user_id', $user_id)->get();
            foreach($notices as $notice) {
                $notice->update(['read' => true]);
            }
            return response()->json(['msg' => 'Đọc thành công'], 204);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 402);
        }
    }

    public function myNotice(Request $request)
    {
        try {
            $user = User::findOrFail(auth()->user()->id);

            $notifications = $user->notifications()
                ->with('sender')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            return response()->json([
                'status' => 1,
                'data' => $notifications,
                'message' => 'Lấy ra thông báo của ' . $user->name . '.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'data' => $th,
                'message' => 'Đã có lỗi xảy ra.'
            ]);
        }
    }
    public function allMyNotice(Request $request)
    {
        try {
            $user = User::findOrFail(auth()->user()->id);

            $notifications = $user->notifications()
                ->with('sender')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status' => 1,
                'data' => $notifications,
                'message' => 'Lấy ra thông báo của ' . $user->name . '.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'data' => $th,
                'message' => 'Đã có lỗi xảy ra.'
            ]);
        }
    }

    public function getAll()
    {
        try {
            $notifications = Notification::select('title', 'content', 'created_at', 'updated_at')->distinct()->orderBy('created_at', 'desc')->get();
        
            return response()->json([
                'status' => 1,
                'data' => $notifications,
                'message' => 'Lấy ra tất cả thông báo.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'data' => $th,
                'message' => 'Đã có lỗi xảy ra.'
            ]);
        }
    }

    public function send(Request $request)
    {
        $data_notification = [
            'title' => $request->input('title'),
            'content' => $request->input('content')
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

        $notification = new Notification([
            'user_id' => $userId,
            'title' => $data_notification['title'],
            'content' => $data_notification['content'],
            'read' => false,
        ]);

        $notification->save();

        $pusher->trigger('chanel-notification', 'event-notification-' . $request->input('user_id'), $data_notification);

        return response()->json([
            'status' => 1,
            'message' => 'Notification sent'
        ]);
    }

    public function sendUsers(Request $request)
    {
        $data_notification = [
            'title' => $request->input('title'),
            'content' => $request->input('content')
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

        foreach ($request->input('user_ids') as $userId) {
            $notification = new Notification([
                'user_id' => $userId,
                'title' => $data_notification['title'],
                'content' => $data_notification['content'],
                'read' => false,
            ]);

            $notification->save();

            $pusher->trigger('chanel-notification', 'event-notification-' . $userId, $data_notification);
        }


        return response()->json([
            'status' => 1,
            'message' => 'Notification sent'
        ]);
    }

    public function sendAll(Request $request)
    {
        $data_notification = [
            'title' => $request->input('title'),
            'content' => $request->input('content')
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

        $users = User::all();
        $userIds = $users->pluck('id')->toArray();

        foreach ($userIds as $userId) {
            $notification = new Notification([
                'user_id' => $userId,
                'title' => $data_notification['title'],
                'content' => $data_notification['content'],
                'read' => false,
            ]);

            $notification->save();
        }

        $pusher->trigger('chanel-notification', 'general-announcement', $data_notification);

        return response()->json([
            'status' => 1,
            'message' => 'Notification sent'
        ]);
    }
}
