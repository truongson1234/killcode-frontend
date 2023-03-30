<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::orderByDesc('created_at')->get();
        return response()->json([
            'data' => $permissions
        ]);
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
        $existingPermission = Permission::where('name', $request->input('name'))->first();

        if ($existingPermission) {
            // Nếu đã tồn tại bản ghi có tiêu đề giống như bản ghi mới, trả về thông báo lỗi
            return response()->json(['error' => 'Quyền này đã tồn tại, vui lòng nhập quyền khác!'], 422);
        }

        $permission = Permission::create([
            'name' => $request->input('name')
        ]);

        return response()->json([
            'data' => $permission
        ], 201);
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

    public function search(Request $request)
    {
        $query = $request->input('q');
        $permissions = Permission::where('name', 'LIKE', '%' . $query . '%')->get();

        return response()->json($permissions);
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
        $permission = Permission::findOrFail($id);
        $permission->update($request->all());

        return response()->json([
            'data' => $permission
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $permission = Permission::findOrFail($id);
            if ($permission->roles()->count() > 0) {
                return response()->json(['error' => 'Quyền này đang được gán cho một hoặc nhiều vai trò khác. Không thể xóa!'], 422);
            }
            if ($permission->users()->count() > 0) {
                return response()->json(['error' => 'Quyền này đang được gán riêng cho một hoặc nhiều người dùng khác. Không thể xóa!'], 422);
            }
            $permission->delete();
            return response()->json(null, 204);
        } catch (QueryException $exception) {
            return response()->json(['error' => 'Không thể xóa quyền này vì có dữ liệu liên quan!'], 422);
        }
    }
    public function getRoleOfPermission($id)
    {
        $permission = Permission::findOrFail($id);
        if($permission) {
            return response()->json(['data' => $permission->roles]);
        }
        return response()->json(['data' => '']);
    }

    public function removeRole($permission_id, $role_id)
    {
        $permission = Permission::findOrFail($permission_id);
        $role = Role::findOrFail($role_id);
        if($permission->hasRole($role)) {
            $permission->removeRole($role);
            return response()->json(['message'=> 'Xóa vai trò thành công!']);
        }
        return response()->json(['error' => 'Xảy ra lỗi khi xóa vai trò!'], 422);
    }

    public function asignRole(Request $request, $permission_id)
    {
        $permission = Permission::findOrFail($permission_id);
        if($permission->hasRole($request->input('name'))) {
            return response()->json(['error' =>  'Vai trò này đã tồn tại!'], 422);
        }
        $permission->assignRole($request->input('name'));
        return response()->json(['message' =>  'Gán quyền thành công!']);
    }
}
