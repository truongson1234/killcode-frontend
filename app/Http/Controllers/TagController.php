<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $tags = Tag::where('name', 'LIKE', '%' . $query . '%')->get();

        return response()->json($tags);
    }

    public function show($id)
    {
        $tag = Tag::findOrFail($id);

        return response()->json($tag);
    }

    public function store(Request $request)
    {
        $tag = Tag::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
        ]);

        return response()->json($tag, 201);
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);

        $tag->update([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
        ]);

        return response()->json($tag, 200);
    }

    public function destroy($id)
    {
        // Tìm tag cần xóa
        $tag = Tag::findOrFail($id);

        // Lấy danh sách bài đăng có liên quan đến tag cần xóa
        $posts = $tag->posts;

        // Xóa tag khỏi mảng tags của các bài đăng có liên quan
        foreach ($posts as $post) {
            $tags = collect($post->tags)->filter(function ($tagId) use ($id) {
                return $tagId !== $id;
            })->values();
            $post->tags = $tags;
            $post->save();
        }

        // Xóa tag
        $tag->delete();

        return response()->json([
            'message' => 'Tag deleted successfully'
        ]);
    }

    public function getPosts($id)
    {
        $tag = Tag::findOrFail($id);
        $posts = $tag->posts;
        return response()->json([
            'posts' => $posts
        ]);
    }
}
