<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
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
        if($request->input('image') != '') {
            $image = $request->input('image');
            $filename = time().$request->input('nameImage');
            Image::make($image)->save(public_path('images/tags/'.$filename));
            Tag::insert([
                'thumbnail' => $filename,
                "name" => $request->input('name'),
                "slug" => $request->input('slug'),
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        }
        return response()->json(['msg' => $filename]);
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
        if($request->input('image') != '') {
            File::delete(public_path('images/tags/'.$tag->thumbnail));
            $image = $request->input('image');
            $filename = time().$request->input('nameImage');
            Image::make($image)->save(public_path('images/tags/'.$filename));
            $tag->thumbnail = $filename;
            $tag->save();
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
            File::delete(public_path('images/tags/'.$tag->thumbnail));

            return response()->json(null, 204);
        }
        return response()->json(['error' => 'Lỗi'], 422);

    }
}
