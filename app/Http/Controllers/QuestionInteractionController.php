<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Question;
use App\Models\QuestionInteraction;

class QuestionInteractionController extends Controller
{
    public function liked(Request $request)
    {
        $interaction = QuestionInteraction::firstOrCreate([
            'user_id' => 2,
            // 'user_id' => auth()->user()->id,
            'question_id' => $request->input('question_id')
        ]);

        $interaction->liked = $interaction->liked ? false : true;

        $interaction->views++;
        
        $interaction->save();


        return response()->json([
            'status' => 1,
            'message' => 'Okla',
        ]);
    }

    public function incrementViews(Request $request)
    {
        $interaction = QuestionInteraction::firstOrCreate([
            'user_id' => 2,
            // 'user_id' => auth()->user()->id,
            'question_id' => $liked = $request->input('question_id')
        ]);

        $interaction->views++;

        $interaction->save();

        return response()->json([
            'status' => 1,
            'message' => 'Okla',
        ]);
    }
}
