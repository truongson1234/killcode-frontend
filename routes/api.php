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
Route::get('/users/{id}', 'App\Http\Controllers\UserController@show');

// posts api
Route::group(['prefix' => 'posts'], function () {
    Route::get('', 'App\Http\Controllers\PostController@index');
    Route::get('{id}', 'App\Http\Controllers\PostController@show');
    Route::post('', 'App\Http\Controllers\PostController@store');
    Route::put('{id}', 'App\Http\Controllers\PostController@update');
    Route::delete('{id}', 'App\Http\Controllers\PostController@destroy');
});

// questions api
Route::group(['prefix' => 'questions'], function () {
    Route::get('', 'App\Http\Controllers\QuestionController@index');
    Route::get('{id}', 'App\Http\Controllers\QuestionController@show');
    Route::post('', 'App\Http\Controllers\QuestionController@store');
    Route::put('{id}', 'App\Http\Controllers\QuestionController@update');
    Route::delete('{id}', 'App\Http\Controllers\QuestionController@destroy');
});

// tags api
Route::group(['prefix' => 'tags'], function () {
    Route::post('follow', 'TagController@followTag');
    Route::post('unfollow', 'TagController@unfollowTag');
    Route::get('/', 'TagController@getAllTags');
    Route::get('{tag_id}', 'TagController@getTag');
    Route::get('{tag_id}/posts', 'TagController@getTagPosts');
    Route::get('{tag_id}/users', 'TagController@getTagFollowers');
    Route::get('{user_id}/user_tags', 'TagController@getUserTags');
});