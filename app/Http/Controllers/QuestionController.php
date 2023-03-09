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
        $question = Question::create($request->all());

        return response()->json([
            'data' => $question
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        $question->update($request->all());

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
