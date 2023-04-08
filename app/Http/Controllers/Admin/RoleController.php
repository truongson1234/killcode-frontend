<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\QueryException;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::whereNotIn('name', ['admin'])->orderByDesc('created_at')->get();
        return response()->json([
            'data' => $roles
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $roles = Role::where('name', 'LIKE', '%' . $query . '%')->get();

        return response()->json($roles);
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
        $existingRole = Role::where('name', $request->input('name'))->first();

        if ($existingRole) {
            // Nếu đã tồn tại bản ghi có tiêu đề giống như bản ghi mới, trả về thông báo lỗi
            return response()->json(['error' => 'Vai trò này đã tồn tại, vui lòng nhập vai trò khác!'], 422);
        }

        $role = Role::create([
            'name' => $request->input('name')
        ]);

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
        $role = Role::findOrFail($id);
        $existRole = Role::where('name', $request->input('name'))->where('id', '<>', $id)->first();
        if($existRole) {
            return response()->json(['error' => 'Tên vai trò này đã tồn tại, vui lòng nhập tên khác!'], 422);
        }
        $role->update($request->all());

        return response()->json([
            'data' => $role
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);
            if ($role->users()->count() > 0) {
                return response()->json(['error' => 'Vai trò này đang được gán cho một hoặc nhiều người dùng khác. Không thể xóa!'], 422);
            }
            // if ($role->permissions()->count() > 0) {
            //     return response()->json(['error' => 'Vai trò này hiện đang liên quan đến một hoặc nhiều quyền khác. Không thể xóa!'], 422);
            // }
            $role->delete();
            return response()->json(null, 204);
        } catch (QueryException $exception) {
            return response()->json(['error' => 'Lỗi!'], 422);
        }
    }

    public function removeRole(Permission $permission, Role $role)
    {
        if($permission->hasRole($role)) {
            $permission->removeRole($role);
            return back()->with('message', 'Remove role success.');
        }
        return back()->with('message', 'error.');
    }

    public function revokePermission($role_id, $permission_id)
    {
        $role = Role::findOrFail($role_id);
        $permission = Permission::findOrFail($permission_id);
        if($role->hasPermissionTo($permission)) {
            $role->revokePermissionTo($permission);
            return response()->json(['message' => 'Thu hồi quyền thành công!']);
        }
        return response()->json(['message' => 'Xảy ra lỗi khi thu hồi quyền!']);
    }
    
    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function givePermission(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        if($role->hasPermissionTo($request->input('name'))) {
            return response()->json(['error' => 'Quyền này đã tồn tại!'], 422);
        }
        $role->givePermissionTo($request->input('name'));
        return response()->json(['data' => 'Cấp quyền cho vai trò thành công!', 'role' => $role->permissions]);
    }

    public function getPermissionOfRole($id)
    {
        $role = Role::findOrFail($id);
        if($role) {
            return response()->json(['data' => $role->permissions]);
        }
        return response()->json(['data' => '']);
    }
}

