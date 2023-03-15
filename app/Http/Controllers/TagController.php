<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\TagUser;
use Illuminate\Http\Request;

class TagController extends Controller
{
    // Follow tag
    public function followTag(Request $request)
    {
        $user_id = $request->user_id;
        $tag_id = $request->tag_id;
        
        $tag_user = new TagUser();
        $tag_user->user_id = $user_id;
        $tag_user->tag_id = $tag_id;
        $tag_user->save();
        
        $tag = Tag::find($tag_id);
        $tag->followers_count = $tag->followers()->count();
        
        return response()->json($tag);
    }

    // Unfollow tag
    public function unfollowTag(Request $request)
    {
        $user_id = $request->user_id;
        $tag_id = $request->tag_id;
        
        $tag_user = TagUser::where('user_id', $user_id)->where('tag_id', $tag_id)->first();
        $tag_user->delete();
        
        $tag = Tag::find($tag_id);
        $tag->followers_count = $tag->followers()->count();
        
        return response()->json($tag);
    }

    // // Thống kê tags của 1 user
    // public function getUserTags($user_id)
    // {
    //     $user = User::find($user_id);
    //     $tags = $user->tags()->withCount('followers')->get();
        
    //     return response()->json($tags);
    // }

    // // Thống kê tags của 1 user
    // public function getTagFollowers($tag_id)
    // {
    //     $tag = Tag::find($tag_id);
    //     $followers = $tag->followers()->withCount('posts')->get();
        
    //     return response()->json($followers);
    // }

    // // Thống kê tags của 1 user
    // public function getAllTags()
    // {
    //     $tags = Tag::all();
        
    //     return response()->json($tags);
    // }

    // // Lấy thông tin chi tiết của một tag cụ thể
    // public function getTag($tag_id)
    // {
    //     $tag = Tag::withCount('followers')->find($tag_id);
        
    //     return response()->json($tag);
    // }

    // // Lấy danh sách các bài đăng được gắn thẻ bằng một tag cụ thể
    // public function getTagPosts($tag_id)
    // {
    //     $tag = Tag::find($tag_id);
    //     $posts = $tag->posts()->get();
        
    //     return response()->json($posts);
    // }

}
