<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Pusher\Pusher;
use App\Models\User;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Notification;

class AnswerController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $answer = Answer::create([
                'content' => $request->input('content'),
                'question_id' => $request->input('question_id'),
                // 'user_id' => 3,
                'user_id' => auth()->user()->id,
            ]);
            
            // config biến conn server Pusher
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                [
                    'cluster' => env('PUSHER_APP_CLUSTER'),
                    'useTLS' => true,
                ]
            );

            $dataAnswer = $answer;

            $dataAnswer->person = [
                'name' => $dataAnswer->user->name,
                'avatar' => 'http://localhost:8000/images/' . $dataAnswer->user->avatar,
                'email' => $dataAnswer->user->email
            ];
            unset($dataAnswer->user);

            $dataAnswer->toArray();

            $pusher->trigger('chanel-answers', 'event-answer-' . $answer->question_id, $dataAnswer);

            // Tạo thông báo
            $data_notification = [
                'title' => 'Thông báo có câu trả lời mới',
                'type_notification' => 'answer',
                'route' => [
                    'name' => 'QuestionDetail',
                    'params' => [
                        'id' => $answer->question_id
                    ]
                ]
            ];

            $questionAskerId = $answer->question->user_id;

            if ($questionAskerId !== $answer->user_id) {
                $notification = Notification::create([
                    'user_id' => $questionAskerId,
                    'sender_id' => $answer->user_id,
                    'title' => $data_notification['title'],
                    'content' => $answer->user->name . ' đã trả lời câu hỏi của bạn',
                    'type_notification' => $data_notification['type_notification'],
                    'route' => $data_notification['route'],
                    'read' => false,
                ]);
    
                $notification['user'] = $notification->user;
                $notification['sender'] = $notification->sender;

                $pusher->trigger('chanel-notification', 'event-notification-' . $notification->user_id, $notification);
            }

            // Gửi thông cho nhưng người đã trả lời trước đó
            $previousAnswers = Answer::select('user_id')
                ->where('question_id', $answer->question_id)
                ->where('user_id', '<>', $answer->user_id)
                ->groupBy('user_id')
                ->get()->each(function ($item, $key) use ($answer, $data_notification, $pusher) {
                    $notification = Notification::create([
                        'user_id' => $item->user_id,
                        'sender_id' => $answer->user_id,
                        'title' => $data_notification['title'],
                        'content' => $answer->user->name . ' đã trả lời câu hỏi mà bạn từng tương tác',
                        'type_notification' => $data_notification['type_notification'],
                        'route' => $data_notification['route'],
                        'read' => false,
                    ]);

                    $notification['user'] = $notification->user;
                    $notification['sender'] = $notification->sender;

                    $pusher->trigger('chanel-notification', 'event-notification-' . $notification->user_id, $notification);
                });

            unset($answer->question);

            return response()->json([
                'data' => $answer,
                'status' => 1,
                'message' => 'Đã trả lời câu hỏi.'
            ], 201);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
