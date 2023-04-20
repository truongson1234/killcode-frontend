<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Question;
use App\Models\Tag;
use App\Models\Interaction;
use App\Models\QuestionInteraction;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $sort_by = $request->input('sort_by', 'latest'); // mặc định sắp xếp theo bài viết mới nhất
        $keyword = $request->input('keyword');
    
        $posts = Post::has('interactions')
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%$keyword%")
                        ->orWhere('body', 'like', "%$keyword%");
            })
            ->with('interactions')
            ->withCount('comments')
            ->withCount(['interactions as likes_count' => function($query) {
                $query->select(\DB::raw("SUM(liked) as likes_count"));
            }])
            ->withCount(['interactions as views_count' => function($query) {
                $query->select(\DB::raw("SUM(views) as views_count"));
            }]);

        $postsWithoutInteractions = Post::doesntHave('interactions')
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%$keyword%")
                        ->orWhere('body', 'like', "%$keyword%");
            })
            ->withCount('comments')
            ->latest()
            ->get()
            ->map(function ($post) {
                $post->likes_count = 0;
                $post->views_count = 0;

                return $post;
            });

        $questions = Question::has('interactions')
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%$keyword%")
                        ->orWhere('body', 'like', "%$keyword%");
            })
            ->with('interactions')
            ->withCount('answers')
            ->withCount(['interactions as likes_count' => function($query) {
                $query->select(\DB::raw("SUM(liked) as likes_count"));
            }])
            ->withCount(['interactions as views_count' => function($query) {
                $query->select(\DB::raw("SUM(views) as views_count"));
            }]);

        $questionsWithoutInteractions = Question::doesntHave('interactions')
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%$keyword%")
                        ->orWhere('body', 'like', "%$keyword%");
            })
            ->withCount('answers')
            ->latest()
            ->get()
            ->map(function ($question) {
                $question->likes_count = 0;
                $question->views_count = 0;

                return $question;
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
                $posts->orderByDesc('likes_count');
                $questions->orderByDesc('likes_count');
                break;
            case 'comments':
                $posts->orderByDesc('comments_count');
                $questions->orderByDesc('answers_count');
                break;
            case 'views':
                $posts->orderByDesc('views_count');
                $questions->orderByDesc('views_count');
                break;
            case 'interactions':
                $posts->orderByDesc('comments_count')
                      ->orderByDesc('likes_count')
                      ->orderByDesc('views_count')
                      ->latest();
                $questions->orderByDesc('answers_count')
                        ->orderByDesc('likes_count')
                        ->orderByDesc('views_count')
                        ->latest();
                $tags->orderByDesc('followers_count')
                    ->orderByDesc('posts_count')
                    ->orderByDesc('questions_count')
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
                'name' => $post->user->name,
                'email' => $post->user->email,
                'avatar' => $post->user->avatar,
            ];
            unset($post->user);
            return $post;
        });
        $dataQuestion = $questions->get()->map(function ($question) {
            $question->author = [
                'name' => $question->user->name,
                'email' => $question->user->email,
                'avatar' => $question->user->avatar,
            ];
            unset($question->user);
            return $question;
        });
        return response()->json([
            'tags' => $tags->get(),
            'posts' => $posts->get(),
            'questions' => $questions->get(),
            'posts_doesnt_interaction' => $postsWithoutInteractions,
            'questions_doesnt_interaction' => $questionsWithoutInteractions,
        ]);
    }
}
