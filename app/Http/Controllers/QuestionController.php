<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with('user')->orderByDesc('created_at')->get();

        return response()->json([
            'data' => $questions,
        ]);
    }

    public function store(Request $request)
    {
        $question = Question::create([
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return response()->json([
            'data' => $question,
            'message' => 'Question created successfully.',
        ], 201);
    }

    public function show(Question $question)
    {
        $question->load('user', 'answers.user');

        return response()->json([
            'data' => $question,
        ]);
    }

    public function update(Request $request, Question $question)
    {
        $question->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return response()->json([
            'data' => $question,
            'message' => 'Question updated successfully.',
        ]);
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return response()->json([
            'message' => 'Question deleted successfully.',
        ]);
    }
}