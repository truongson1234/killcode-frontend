<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $currentPage = $request->input('page', 1);
        $perPage = $request->input('perPage', 3);
        
        $paginator = Post::with('user')->paginate($perPage);
        $posts = collect($paginator->items())
            ->map(function ($post) {
                $post->author = [
                    'name' => $post->user->name,
                    'email' => $post->user->email,
                ];
                unset($post->user);
                return $post;
            });

        return response()->json([
            'currentPage' => $paginator->currentPage(),
            'totalPages' => $paginator->lastPage(),
            'data' => $posts->all()
        ]);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);

        return response()->json($post);
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
