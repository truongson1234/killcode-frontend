<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Interaction;

class InteractionController extends Controller
{
    public function liked(Request $request)
    {
        $interaction = Interaction::firstOrCreate([
            // 'user_id' => 1,
            'user_id' => auth()->user()->id,
            'post_id' => $request->input('post_id')
        ]);

        $interaction->liked = $interaction->liked ? false : true;

        $interaction->save();

        $interaction_counts = Post::withCount(['interactions as likes_count' => function($query) {
                                $query->select(\DB::raw("SUM(liked) as likes_count"));
                            }])
                            ->withCount(['interactions as views_count' => function($query) {
                                $query->select(\DB::raw("SUM(views) as views_count"));
                            }])->findOrFail($request->input('post_id'));

        return response()->json([
            'liked' => $interaction->liked,
            'likes_count' => $interaction_counts->likes_count,
            'views_count' => $interaction_counts->views_count,
            'status' => 1,
        ]);
    }

    public function incrementViews(Request $request)
    {
        $interaction = Interaction::firstOrCreate([
            // 'user_id' => 1,
            'user_id' => auth()->user()->id,
            'post_id' => $liked = $request->input('post_id')
        ]);

        $interaction->views++;

        $interaction->save();

        return response()->json([
            'message' => 'hi',
        ]);
    }

}
