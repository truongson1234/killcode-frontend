<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        return response()->json([
            'data' => $posts
        ]);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);

        return response()->json([
            'data' => $post
        ]);
    }

    public function store(Request $request)
    {
        // Create post data in database
        $post = new Post();
        // $post->user_id = auth()->user()->id;
        $post->user_id = $request->input('user_id');
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->tags = $request->input('tags');
        $post->views = $request->input('views');
        $post->likes = $request->input('likes');
        $post->save();

        // Return created post data
        return response()->json([
            'data' => $post
        ], 201);
    }

    public function update(Request $request, $id)
    {
        // Update post data in database
        $post = Post::findOrFail($id);
        $post->update($request->all());

        // Return updated post data
        return response()->json([
            'data' => $post
        ]);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json(null, 204);
    }
}
