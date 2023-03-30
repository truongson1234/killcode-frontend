<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Events\TestEvent;
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

        event(new TestEvent());

        // Return created post data
        return response()->json([
            'data' => $post,
            'status' => 1,
            'message' => 'Tạo thành công.'
        ], 201);
    }

    public function update(Request $request, $id)
    {
        // Update post data in database
        $post = Post::findOrFail($id);
        $post->update($request->all());

        // Return updated post data
        return response()->json([
            'data' => $post,
            'status' => 1,
            'message' => 'Cập nhật thành công.'
        ]);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Delete post successfully.'
        ], 204);
    }
}
