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
    
        $posts = Post::withCount('comments')->with('tags')->where(function ($query) use ($keyword) {
            $query->where('title', 'like', "%$keyword%")
                ->orWhere('body', 'like', "%$keyword%");
        });
        
        $questions = Question::withCount('answers')->with('tags')->where(function ($query) use ($keyword) {
            $query->where('title', 'like', "%$keyword%")
                    ->orWhere('body', 'like', "%$keyword%");
        });

        $tags = Tag::withCount('followers', 'posts', 'questions')->where(function ($query) use ($keyword) {
            $query->where('name', 'like', "%$keyword%")
                    ->orWhere('slug', 'like', "%$keyword%");
        });
    
        // sắp xếp theo thứ tự mong muốn
        switch ($sort_by) {
            case 'latest':
                $posts->latest(); // sắp xếp theo bài viết mới nhất
                $questions->latest();
                $tags->latest();
                break;
            case 'likes':
                $posts->orderBy('likes', 'desc'); // sắp xếp theo số lượt thích giảm dần
                $questions->orderBy('likes', 'desc');
                break;
            case 'comments':
                $posts->orderBy('comments_count', 'desc'); // sắp xếp theo số lượt bình luận giảm dần
                $questions->orderBy('answers_count', 'desc');
                break;
            case 'views':
                $posts->orderBy('views', 'desc'); // sắp xếp theo số lượt xem giảm dần
                $questions->orderBy('views', 'desc');
                break;
            case 'interactions':
                $posts->orderBy('comments_count', 'desc')
                      ->orderBy('likes', 'desc')
                      ->orderBy('views', 'desc')
                      ->latest(); // sắp xếp theo số lượt tương tác (comments, likes, views) giảm dần
                $questions->orderBy('answers_count', 'desc')
                        ->orderBy('likes', 'desc')
                        ->orderBy('views', 'desc')
                        ->latest();
                $tags->orderBy('followers_count', 'desc')
                    ->orderBy('posts_count', 'desc')
                    ->orderBy('questions_count', 'desc')
                    ->latest();
                break;
            default:
                $posts->latest();
                $questions->latest();
                $tags->latest();
                break;
        }
        $dataPosts = $posts->get()->map(function ($post) {
            $post->author = [
                'id' => $post->user->id,
                'name' => $post->user->name,
                'email' => $post->user->email,
                'avatar' => $post->user->avatar,
            ];
            unset($post->user);
            return $post;
        });
        $dataQuestion = $questions->get()->map(function ($question) {
            $question->author = [
                'id' => $question->user->id,
                'name' => $question->user->name,
                'email' => $question->user->email,
                'avatar' => $question->user->avatar,
            ];
            unset($question->user);
            return $question;
        });
        return response()->json([
            'posts' => $dataPosts,
            'questions' => $dataQuestion,
            'tags' => $tags->get(),
        ]);
    }
}
