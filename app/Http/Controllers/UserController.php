<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderByDesc('created_at')->get();
        // foreach ($users as $item) {
        //     $roles = [];
        //     $userRoles = DB::table('user_roles')
        //         ->leftJoin('users', 'users.id', '=', 'user_roles.user_id')
        //         ->leftJoin('roles', 'roles.id', '=', 'user_roles.role_id')
        //         ->select('users.name', 'roles.name as role_name', 'roles.id as role_id')
        //         ->where('users.id', $item->id)
        //         ->get();
        //     foreach ($userRoles as $userRole) {
        //         $roles[] = [
        //             'name' => $userRole->role_name,
        //             'id' => $userRole->role_id
        //         ] ;
        //     }
        //     $item->role = $roles;
        // }
        return response()->json([
            'data' => $users,
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $permissions = Permission::all();
        return response()->json(['user_role' => $user->roles, 'user_permission' => $user->permissions, 'roles' => $roles, 'permissions' => $permissions]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function asignRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if($user->hasRole($request->input('name'))) {
            return response()->json(['error' => 'Vai trò đã tồn tại!'], 422);
        }
        $user->assignRole($request->input('name'));
        return response()->json(['message' =>'Role added.']);
    }

    public function removeRole($user_id, $role_id)
    {
        $user = User::findOrFail($user_id);
        $role = Role::findOrFail($role_id);
        if($user->hasRole($role)) {
            $user->removeRole($role);
            return response()->json(['message' => 'Xóa vai trò thành công!']);
        }
        return response()->json(['message' => 'error.'], 422);
    }

    public function givePermission(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if($user->hasPermissionTo($request->input('name'))) {
            return response()->json(['error' => 'Quyền đã tồn tại!'], 422);
        }
        $user->givePermissionTo($request->input('name'));
        return response()->json(['message' => 'Thêm quyền thành công!']);
    }
    public function revokePermission($user_id, $permission_id)
    {
        $user = User::findOrFail($user_id);
        $permission = Permission::findOrFail($permission_id);
        if($user->hasPermissionTo($permission)) {
            $user->revokePermissionTo($permission);
            return response()->json(['message' => 'Thu hồi quyền thành công!']);
        }
        return response()->json(['message' => 'Lỗi trong quá trình thu hồi quyền!'], 422);
    }
}
