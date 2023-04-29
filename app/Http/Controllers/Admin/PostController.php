<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Carbon\Carbon;

class PostController extends Controller
{
    public $new_posts;

    public function load_posts()
    {
        $this->posts = Post::with('user', 'tags', 'status')
        ->withCount('comments')
        ->withCount(['interactions as likes_count' => function($query) {
            $query->select(\DB::raw("SUM(liked) as likes_count"));
        }])
        ->withCount(['interactions as views_count' => function($query) {
            $query->select(\DB::raw("SUM(views) as views_count"));
        }])
        ->get();
    }

    public function __construct()
    {
        $this->load_posts();
    }

    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $posts = Post::where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%$keyword%")
                        ->orWhere('body', 'like', "%$keyword%");
            })
            ->with('user', 'tags', 'status')
            ->withCount('comments')
            ->withCount(['interactions as likes_count' => function($query) {
                $query->select(\DB::raw("SUM(liked) as likes_count"));
            }])
            ->withCount(['interactions as views_count' => function($query) {
                $query->select(\DB::raw("SUM(views) as views_count"));
            }])
            ->get();

        return response()->json([
            'posts' => $posts,
        ]);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->tags()->detach();
        $post->comments()->delete();
        $post->delete();

        $this->load_posts();
        return response()->json([
            'posts' => $this->posts,
            'status' => 1,
            'message' => 'Delete post successfully.'
        ]);
    }
}
