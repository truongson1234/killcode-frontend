<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Question;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $sort_by = $request->input('sort_by', 'latest'); // mặc định sắp xếp theo bài viết mới nhất
        $keyword = $request->input('keyword');
    
        $posts = Post::withCount('comments')->where(function ($query) use ($keyword) {
            $query->where('title', 'like', "%$keyword%")
                    ->orWhere('body', 'like', "%$keyword%");
        });

        // $questions = Question::withCount('answers')->where(function ($query) use ($keyword) {
        //     $query->where('title', 'like', "%$keyword%")
        //             ->orWhere('body', 'like', "%$keyword%");
        // });

        $tags = Tag::withCount('followers')->where(function ($query) use ($keyword) {
            $query->where('name', 'like', "%$keyword%")
                    ->orWhere('slug', 'like', "%$keyword%");
        });
    
        // sắp xếp theo thứ tự mong muốn
        switch ($sort_by) {
            case 'latest':
                $posts->latest(); // sắp xếp theo bài viết mới nhất
                $tags->latest();
                break;
            case 'likes':
                $posts->orderBy('likes', 'desc'); // sắp xếp theo số lượt thích giảm dần
                break;
            case 'comments':
                $posts->orderBy('comments_count', 'desc'); // sắp xếp theo số lượt bình luận giảm dần
                break;
            case 'views':
                $posts->orderBy('views', 'desc'); // sắp xếp theo số lượt xem giảm dần
                break;
            case 'interactions':
                $posts->orderBy('comments_count', 'desc')
                      ->orderBy('likes', 'desc')
                      ->orderBy('views', 'desc')
                      ->latest(); // sắp xếp theo số lượt tương tác (comments, likes, views) giảm dần
                $tags->orderBy('followers_count', 'desc')->latest();
                break;
            default:
                $posts->latest();
                $tags->latest();
                break;
        }
    
        // trả về kết quả dưới dạng một đối tượng JSON
        return response()->json([
            'posts' => $posts->get(),
            'tags' => $tags->get(),
        ]);
    }
}
