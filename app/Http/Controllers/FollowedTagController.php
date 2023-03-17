<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FollowedTagController extends Controller
{
    // Lấy danh sách các thẻ đã được theo dõi của một người dùng
    public function index(Request $request)
    {
        $userId = $request->input('user_id');
        $tagId = $request->input('tag_id');

        $followedTags = FollowedTag::where('user_id', $userId)->with('tag')->get();

        return response()->json($followedTags);
    }

    // Theo dõi một thẻ mới
    public function store(Request $request)
    {
        $tagId = $request->input('user_id');
        $tagId = $request->input('tag_id');

        $tag = Tag::findOrFail($tagId);

        $followedTag = new FollowedTag;
        $followedTag->user_id = $userId;
        $followedTag->tag_id = $tagId;
        $followedTag->save();

        return response()->json($followedTag);
    }

    // Bỏ theo dõi một thẻ
    public function destroy(Request $request)
    {
        $tagId = $request->input('user_id');
        $tagId = $request->input('tag_id');

        $followedTag = FollowedTag::where('user_id', $userId)->where('tag_id', $tagId)->firstOrFail();
        $followedTag->delete();

        return response()->json(['message' => 'Unfollowed tag successfully.']);
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
