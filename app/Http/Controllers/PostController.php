<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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

        return response()->json([
            'data' => $post
        ]);
    }

    public function store(Request $request)
    {
        // Create post data in database
        $post = new Post();
        $post->user_id = auth()->user()->id;
        // $post->user_id = $request->input('user_id');
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->views = $request->input('views');
        $post->likes = $request->input('likes');
        $post->save();

        // Lấy danh sách các tag từ request
        $tagIds = $request->input('tag_ids');

        // Đính kèm các tag vào bài viết
        $post->tags()->attach($tagIds);

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

        return response()->json(['message' => 'Delete post successfully.'], 204);
    }
}
