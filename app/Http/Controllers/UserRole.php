<?php

namespace App\Http\Controllers;

use App\Models\UserRoles;
use Illuminate\Http\Request;

class UserRole extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $user_id = $request->input('user_id');
        $role_id = $request->input('role_id');

        if(UserRoles::where('user_id', $user_id)->where('role_id', $role_id)->exists()) {
            return response()->json(['error' => 'Quyền này đã tồn tại, không thể thêm!'], 422);
        } else {
            // Dữ liệu chưa tồn tại, thực hiện thêm mới dữ liệu vào bảng user_roles
            $userRole = new UserRoles;
            $userRole->user_id = $user_id;
            $userRole->role_id = $role_id;
            $userRole->save();
            return response()->json([
                'data' => $userRole
            ], 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserRoles  $userRoles
     * @return \Illuminate\Http\Response
     */
    public function show(UserRoles $userRoles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserRoles  $userRoles
     * @return \Illuminate\Http\Response
     */
    public function edit(UserRoles $userRoles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserRoles  $userRoles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserRoles $userRoles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserRoles  $userRoles
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id, $role_id)
    {
        UserRoles::where('user_id', $user_id)->where('role_id', $role_id)->delete();
        return response()->json('SUCCESS!', 204);
    }
}
