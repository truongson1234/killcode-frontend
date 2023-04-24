<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Question;
use App\Models\Tag;
use App\Models\Interaction;

class StatisticalController extends Controller
{
    //
    public function index (Request $request)
    {
        $liked = Interaction::where('liked', true)->count();
        $views = Interaction::whereNotNull('views')->count();

        $totalInteractions = $liked + $views;
        $totalPosts = Post::count();
        $totalQuestions = Question::count();
        $totalTags = Tag::count();

        return response()->json([
            'total_interactions' => $totalInteractions,
            'total_posts' => $totalPosts,
            'total_questions' => $totalQuestions,
            'total_tags' => $totalTags,
        ]);
    }
}
