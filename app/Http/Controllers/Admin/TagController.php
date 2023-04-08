<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::orderBy('created_at', 'desc')->get();
        return response()->json(['data' => $tags], 201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $existTag = Tag::where('name', $request->input('name'))->first();
        $existSlug = Tag::where('slug', $request->input('slug'))->first();
        if($existTag) {
            return response()->json(['error' => 'Tên thẻ này đã tồn tại, vui lòng nhập thẻ khác!'], 422);
        }
        if($existSlug) {
            return response()->json(['error' => 'Tên slug này đã tồn tại, vui lòng nhập slug khác!'], 422);
        }
        Tag::create($request->all());
        return response()->json(['msg' => 'Thêm mới thẻ thành công'], 204);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);
        $existNameTag = Tag::where('name', $request->input('name'))->where('id', '<>', $id)->first();
        $existSlugTag = Tag::where('slug', $request->input('slug'))->where('id', '<>', $id)->first();
        if($existNameTag) {
            return response()->json(['error' => 'Tên thẻ này đã tồn tại, vui lòng nhập tên khác!'], 422);
        }
        if($existSlugTag) {
            return response()->json(['error' => 'Tên slug này đã tồn tại, vui lòng nhập slug khác!'], 422);
        }
        $tag->update($request->all());
        return response()->json(null, 204);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        if($tag) {
            $tag->delete();
            return response()->json(null, 204);
        }
        return response()->json(['error' => 'Lỗi'], 422);

    }
}
