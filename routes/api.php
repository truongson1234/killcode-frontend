<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    return $request->user();
});

// Get user by id
Route::group(['prefix' => 'users'], function () {
    Route::get('{id}', 'App\Http\Controllers\UserController@show');
    Route::get('{user}/followed-tags', 'App\Http\Controllers\FollowedTagController@index');
    Route::post('{user}/followed-tags', 'App\Http\Controllers\FollowedTagController@store');
    Route::delete('{user}/followed-tags/{tag}', 'App\Http\Controllers\FollowedTagController@destroy');
    Route::get('{user}/followed-tags/{tag}', 'App\Http\Controllers\FollowedTagController@show');
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

// roles api
Route::group(['prefix' => 'roles'], function () {
    Route::get('', 'App\Http\Controllers\RolesController@index');
    Route::post('', 'App\Http\Controllers\RolesController@store');
    Route::delete('{id}', 'App\Http\Controllers\RolesController@destroy');
    Route::put('{id}', 'App\Http\Controllers\RolesController@update');
    Route::get('search', 'App\Http\Controllers\RolesController@search');
});

// user roles api
Route::group(['prefix' => 'user-roles'], function () {
    Route::post('', 'App\Http\Controllers\UserRole@store');
    Route::post('{user_id}&{role_id}', 'App\Http\Controllers\UserRole@destroy');
});

Route::group(['prefix' => 'users'], function () {
    Route::get('', 'App\Http\Controllers\UserController@index');
    // Route::post('', 'App\Http\Controllers\RolesController@store');
    // Route::delete('{id}', 'App\Http\Controllers\RolesController@destroy');
    // Route::put('{id}', 'App\Http\Controllers\RolesController@update');
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
