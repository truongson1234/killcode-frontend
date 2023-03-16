<?php

namespace App\Http\Controllers;
use Illuminate\Database\QueryException;
use App\Models\Roles;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Roles::all();
        return response()->json([
            'data' => $roles
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $tags = Roles::where('name', 'LIKE', '%' . $query . '%')->get();

        return response()->json($tags);
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
        // Create role data in database
        $existingRole = Roles::where('name', $request->input('name'))->first();

        if ($existingRole) {
            // Nếu đã tồn tại bản ghi có tiêu đề giống như bản ghi mới, trả về thông báo lỗi
            return response()->json(['error' => 'Quyền này đã tồn tại, vui lòng nhập quyền khác!'], 422);
        }

        $role = new Roles();
        $role->name = $request->input('name');
        $role->save();

        // Return created role data
        return response()->json([
            'data' => $role
        ], 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function show(Roles $roles)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function edit(Roles $roles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Update role data in database
        $role = Roles::findOrFail($id);
        $role->update($request->all());

        // Return role post data
        return response()->json([
            'data' => $role
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $role = Roles::findOrFail($id);
            $role->delete();
    
            return response()->json(null, 204);
            // return response()->json(['success' => true]);
        } catch (QueryException $exception) {
            return response()->json(['error' => 'Không thể xóa quyền này vì có dữ liệu liên quan!'], 422);
        }
    }
}
