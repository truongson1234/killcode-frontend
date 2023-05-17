<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\FollowedTag;
use Illuminate\Http\Request;

class FollowedTagController extends Controller
{
    // Lấy danh sách các thẻ đã được theo dõi của một người dùng
    public function index(Request $request)
    {
        if(auth()->user()) {
            $data_query = Tag::with(['followers' => function ($query) { 
                    $query->where('user_id', auth()->user()->id); 
                }])     
                ->withCount([
                    'followers',
                    'posts' => function ($query) {
                        $query->where('status_id', 1);
                    },
                    'questions' => function ($query) {
                        $query->where('status_id', 1);
                    },
                ])
                ->orderBy('created_at', 'desc') 
                ->get();

            $tags = $data_query->map(function ($tag) { 
                $tag->is_following = $tag->followers->isNotEmpty();
    
                unset($tag->followers); 
                return $tag; 
            });
    
            return response()->json([
                'data' => $tags,
            ],200);
        }else {
            $tags = Tag::withCount('posts', 'questions', 'followers')->orderBy('created_at', 'desc')->get();
            return response()->json([
                'data' => $tags,
            ],200);
        }
    }

    //Get ra tag hiện tại xem đã follow hay chưa với id Tag
    public function getFollowedTagById($id) {
        if(auth()->user()) {
            $data_query = Tag::where('id', $id)
                        ->with([
                            'followers' => function ($query) { 
                                $query->where('user_id', auth()->user()->id); 
                            }
                        ])     
                        ->withCount([
                            'followers',
                            'posts' => function ($query) {
                                $query->where('status_id', 1);
                            },
                            'questions' => function ($query) {
                                $query->where('status_id', 1);
                            },
                        ])
                        ->orderBy('created_at', 'desc')
                        ->get();

            $tags = $data_query->map(function ($tag) { 
                $tag->is_following = $tag->followers->isNotEmpty();
    
                unset($tag->followers); 
                return $tag; 
            });
    
            return response()->json([
                'data' => $tags,
            ],200);
        }else {
            $tags = Tag::where('id', $id)->withCount('posts', 'questions', 'followers')->orderBy('created_at', 'desc')->get();
            return response()->json([
                'data' => $tags,
            ],200);
        }
    }

    // Theo dõi một thẻ mới
    public function store(Request $request)
    {
        if (auth()->user()->hasPermissionTo('follow-tag')) {
            $userId = auth()->user()->id;
            $tagId = $request->input('tag_id');
            
            if (!FollowedTag::where('user_id', $userId)->where('tag_id', $tagId)->exists()) {
                $followedTag = new FollowedTag;
                $followedTag->user_id = $userId;
                $followedTag->tag_id = $tagId;
                $followedTag->save();
        
                return response()->json([
                    'data' => $followedTag,
                    'status' => 1,
                    'message' => 'Follow thành công.'
                ],200);
            }

            return response()->json([
                'status' => 0,
                'message' => 'Bạn đã follow trước đó rồi.'
            ],404);
        } else {
            return response()->json([
                'data' => [],
                'status' => 0,
                'message' => 'Bạn không có quyền theo dõi chủ đề!'
            ]);
        }
    }

    // Bỏ theo dõi một thẻ
    public function destroy(Request $request)
    {
        if (auth()->user()->hasPermissionTo('unfollow-tag')) {
            $userId = auth()->user()->id;
            $tagId = $request->input('tag_id');

            $followedTag = FollowedTag::where('user_id', $userId)->where('tag_id', $tagId)->firstOrFail();
            $followedTag->delete();

            return response()->json([
                'status' => 1,
                'message' => 'Bỏ theo dõi thành công.'
            ]);
        } else {
            return response()->json([
                'data' => [],
                'status' => 0,
                'message' => 'Bạn không có quyền hủy theo dõi chủ đề!'
            ]);
        }
    }

    // Kiểm tra một thẻ đã được theo dõi hay chưa
    public function show(Request $request)
    {
        $tagId = $request->input('user_id');
        $tagId = $request->input('tag_id');

        $followedTag = FollowedTag::where('user_id', $userId)->where('tag_id', $tagId)->first();
        
        if ($followedTag) {
            return response()->json(['message' => 'Tag is followed.']);
        } else {
            return response()->json(['message' => 'Tag is not followed.']);
        }
    }
}
