<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostStatus;

class PostStatusController extends Controller
{
    public function index ()
    {
        $post_statuses = PostStatus::all()->map(function ($post_status) {
            $post_status->posts;
            return $post_status;
        });

        return response()->json([
            'post_statuses' => $post_statuses,
        ]);
    }

    public function store(Request $request, PostStatus $post_status)
    {
        $post_status->create([
            'name' => $request->input('name'),
            'describe' => $request->input('describe'),
        ]);
        
        return response()->json([
            'status' => 1,
            'message' => 'Đã tạo thành công trạng thái.'
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $post_status = PostStatus::findOrFail($id);

        $post_status->update([
            'name' => $request->input('name'),
            'describe' => $request->input('describe'),
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Cập nhật thành công.'
        ]);
    }

    public function destroy($id)
    {
        $post_status = PostStatus::findOrFail($id);

        if (!$post_status->is_default) {
            $post_status->delete();

            return response()->json([
                'status' => 1,
                'message' => 'Xóa thành công trạng thái.'
            ], 200);
        }

        return response()->json([
            'status' => 0,
            'message' => 'Không thể xóa.'
        ], 200);
    }
}
