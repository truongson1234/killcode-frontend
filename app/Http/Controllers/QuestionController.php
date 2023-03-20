<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::all();

        return response()->json([
            'data' => $questions
        ]);
    }

    public function show($id)
    {
        $questions = Question::findOrFail($id);

        return response()->json([
            'data' => $questions
        ]);
    }

    public function store(Request $request)
    {
        // Create question data in database
        $question = new Question();
        $question->user_id = auth()->user()->id;
        // $question->user_id = $request->input('user_id');
        $question->title = $request->input('title');
        $question->body = $request->input('body');
        $question->tags = $request->input('tags');
        $question->views = $request->input('views');
        $question->likes = $request->input('likes');
        $question->save();

        // Return created question data
        return response()->json([
            'data' => $question
        ], 201);
    }

    public function update(Request $request, $id)
    {
        // Update question data in database
        $question = Question::findOrFail($id);
        $question->update($request->all());

        // Return question post data
        return response()->json([
            'data' => $question
        ]);
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return response()->json(null, 204);
    }
}
