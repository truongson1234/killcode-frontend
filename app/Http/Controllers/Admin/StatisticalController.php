<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Question;
use App\Models\Tag;
use App\Models\Interaction;
use App\Models\QuestionInteraction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatisticalController extends Controller
{
    //
    public function index (Request $request)
    {
        $likes = Interaction::where('liked', true)->count();
        $views = Interaction::whereNotNull('views')->count();

        $questions_likes = QuestionInteraction::where('liked', true)->count();
        $questions_views = QuestionInteraction::whereNotNull('views')->count();

        $totalInteractions = ($likes + $views) + ($questions_likes + $questions_views);
        $totalPosts = Post::whereDate('created_at', today())->count();
        $totalQuestions = Question::whereDate('created_at', today())->count();
        $totalTags = Tag::whereDate('created_at', today())->count();

        $tags = Tag::select('name')->get()->map(function ($tag) {
            $tag->total_posts = $tag->posts->count();
            $tag->total_questions = $tag->questions->count();
            $tag->total_followers = $tag->followers->count();

            unset($tag->posts);
            unset($tag->questions);
            unset($tag->followers);

            return $tag;
        });

        $categorys = [
            'posts' => [
                'name' => 'Bài viết',
                'icon' => "<i class='bx bxs-book text-white opacity-10'></i>",
                'total' => Post::count(),
            ],
            'questions' => [
                'name' => 'Câu hỏi',
                'icon' => "<i class='bx bx-question-mark text-white opacity-10'></i>",
                'total' => Question::count(),
            ],
            'tags' => [
                'name' => 'Thẻ',
                'icon' => "<i class='bx bxs-purchase-tag-alt text-white opacity-10'></i>",
                'total' => Tag::count(),
            ]
        ];

        $interactions = Interaction::selectRaw('MONTH(created_at) as month, sum(liked + views) as interactions')
            ->groupBy('month')
            ->get();

        $questionInteractions = QuestionInteraction::selectRaw('MONTH(created_at) as month, sum(liked + views) as interactions')
            ->groupBy('month')
            ->get();

        $chart = array_fill(0, 12, 0);

        foreach (array_merge($interactions->toArray(), $questionInteractions->toArray()) as $interaction) {
            $month = intval($interaction['month']);
            $chart[$month] += intval($interaction['interactions']);
        }
        
        return response()->json([
            'total_interactions' => $totalInteractions,
            'total_posts' => $totalPosts,
            'total_questions' => $totalQuestions,
            'total_tags' => $totalTags,
            'tags' => $tags,
            'categorys' => $categorys,
            'chart' => $chart
        ]);
    }
}
