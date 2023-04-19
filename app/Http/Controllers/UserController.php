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
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = User::findOrFail($request->input('idUser'));
        $mailExist = User::where('email', $request->input('email'))->where('id','<>', $request->input('idUser'))->first();

        if(!$mailExist) {
            if($request->input('image') != '') {
                $image = $request->input('image');
                $filename = time().$request->input('nameImage');
                if (file_exists(public_path('images/'.$user->avatar)) && $user->avatar != 'user.png') {
                    File::delete(public_path('images/'.$user->avatar));
                }
                Image::make($image)->save(public_path('images/'.$filename));
                $user->update([
                    'avatar' => $filename,
                ]);
            }
            if($request->input('email') != $user->email) {
                $user->email_verified_at = null;
                $user->email = $request->input('email');
                $user->save(); 
                $user->sendEmailVerificationNotification();
            }
            $user->update([
                'name' => $request->input('name'),
            ]);
            return response()->json(['msg' => 'Cập nhật thành công!']);
        }
        return response()->json(['error' => 'Email này đã tồn tại!'], 422);

    }

    public function getUserById($id) {
        $user = User::findOrFail($id);
        $user->avatar = 'http://localhost:8000/images/'.$user->avatar;
        return response()->json(['user' => $user]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderByDesc('created_at')->get();
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
        return response()->json(['user' => $user, 'user_role' => $user->roles, 'user_permission' => $user->permissions, 'roles' => $roles, 'permissions' => $permissions]);
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
