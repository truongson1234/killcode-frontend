<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    $user = $request->user();
    $roles = $user->getRoleNames();
    $permissions = $user->getPermissionNames();
    return [
        'user' => $user,
        'roles' => $roles,
        'permissions' => $permissions,
    ];
});

Route::group(['prefix' => 'user'], function () {
    Route::post('update-profile', [UserController::class, 'updateProfile']);
});
// Get user by id
Route::group(['prefix' => 'users'], function () {
    Route::get('{id}', 'App\Http\Controllers\UserController@show');
});

// followed-tags api
Route::group(['prefix' => 'followed-tags'], function () {
    Route::get('', 'App\Http\Controllers\FollowedTagController@index');
    Route::post('', 'App\Http\Controllers\FollowedTagController@store');
    Route::delete('', 'App\Http\Controllers\FollowedTagController@destroy');
});

// posts api
Route::group(['prefix' => 'posts'], function () {
    Route::get('', 'App\Http\Controllers\PostController@index');
    Route::get('{id}', 'App\Http\Controllers\PostController@show');
    Route::post('', 'App\Http\Controllers\PostController@store');
    Route::put('{id}', 'App\Http\Controllers\PostController@update');
    Route::delete('{id}', 'App\Http\Controllers\PostController@destroy');
});

// Route::middleware(['auth:sanctum'])->get('/posts2', function (Request $request) {
//     return $request->user();
// });

// questions api
Route::group(['prefix' => 'questions'], function () {
    Route::get('', 'App\Http\Controllers\QuestionController@index');
    Route::get('{id}', 'App\Http\Controllers\QuestionController@show');
    Route::post('', 'App\Http\Controllers\QuestionController@store');
    Route::put('{id}', 'App\Http\Controllers\QuestionController@update');
    Route::delete('{id}', 'App\Http\Controllers\QuestionController@destroy');
});

//! API VAI TRÒ 
Route::group(['prefix' => 'roles'], function () {
    Route::get('', [RoleController::class, 'index']);
    Route::put('{id}', [RoleController::class, 'update']);
    Route::post('', [RoleController::class, 'store']);
    Route::delete('{id_role}', [RoleController::class, 'destroy']);
    Route::get('search', [RoleController::class, 'search']);

    Route::get('{id_role}/permissions', [RoleController::class, 'getPermissionOfRole']);
    Route::post('{id_role}/permissions', [RoleController::class, 'givePermission']);
    Route::delete('{role_id}/permissions/{permission_id}', [RoleController::class, 'revokePermission']);

});

//! API QUYỀN 
Route::group(['prefix' => 'permissions'], function () {
    Route::get('', [PermissionController::class, 'index']);
    Route::post('', [PermissionController::class, 'store']);
    Route::put('{id}', [PermissionController::class, 'update']);
    Route::delete('{id_permission}', [PermissionController::class, 'destroy']);
    Route::get('search', [PermissionController::class, 'search']);
    
    Route::get('{id_permission}/roles', [PermissionController::class, 'getRoleOfPermission']);
    Route::post('{permission_id}/roles', [PermissionController::class, 'asignRole']);
    Route::delete('{permission_id}/roles/{role_id}', [PermissionController::class, 'removeRole']);
});

//! API TƯƠNG TÁC GIỮA NGƯỜI DÙNG VỚI QUYỀN VÀ VAI TRÒ
Route::group(['prefix' => 'users'], function () {
    Route::get('', [UserController::class, 'index']);
    Route::get('{user_id}', [UserController::class, 'show']);

    Route::post('{user_id}/roles', [UserController::class, 'asignRole']);
    Route::delete('{user_id}/roles/{role_id}', [UserController::class, 'removeRole']);
    Route::post('{user_id}/permissions', [UserController::class, 'givePermission']);
    Route::delete('{user_id}/permissions/{permission_id}', [UserController::class, 'revokePermission']);
});

// tags api
Route::group(['prefix' => 'tags'], function () {
    Route::get('', 'App\Http\Controllers\TagController@index');
    Route::get('{id}', 'App\Http\Controllers\TagController@show');
    Route::post('', 'App\Http\Controllers\TagController@store');
    Route::put('{id}', 'App\Http\Controllers\TagController@update');
    Route::delete('{id}', 'App\Http\Controllers\TagController@destroy');
    Route::get('get-posts/{id}', 'App\Http\Controllers\TagController@getPosts');
});
