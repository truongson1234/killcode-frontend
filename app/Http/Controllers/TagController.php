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
        $query = Tag::where('name', 'LIKE', '%' . $request->input('q') . '%')->withCount('posts');
        $tags = $query->get();
        $count = $tags->count();

        return response()->json([
            'total' => $count,
            'tags' => $tags
        ]);
    }

    public function show($id)
    {
        $tag = Tag::findOrFail($id);
        // Số bài viết, câu hỏi và người theo dõi tag 
        $post_count = $tag->posts()->count();
        $question_count = $tag->questions()->count();
        $followers = $tag->followers()->count();

        // Danh bài viết, câu hỏi, người theo dõi tag
        $posts = $tag->posts()->with('tags')->get();
        $posts = $posts->map(function($post) {
            $post->author = [
                'id' => $post->user->id,
                'name' => $post->user->name,
                'email' => $post->user->email,
                'avatar' => 'http://localhost:8000/images/'.$post->user->avatar,
            ];
            unset($post->user);
            return $post;
        });

        //Tag phổ biến
        $popular_tags = Tag::withCount('posts')->orderBy('posts_count', 'desc')->take(10)->get();

        $questions = $tag->questions()->with('tags')->get();
        $questions = $questions->map(function($question) {
            $question->author = [
                'id' => $question->user->id,
                'name' => $question->user->name,
                'email' => $question->user->email,
                'avatar' => 'http://localhost:8000/images/'.$question->user->avatar,
            ];
            unset($question->user);
            return $question;
        });
        $followeds = $tag->followers()->get();
        foreach($followeds as $followed) {
            $followed->avatar = 'http://localhost:8000/images/'.$followed->avatar;

        }

        return response()->json([
            'post_count' => $post_count,
            'question_count' => $question_count,
            'followers' => $followers,
            'popular_tags' => $popular_tags,
            'posts' => $posts,
            'questions' => $questions,
            'followeds' => $followeds,
        ]);
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
