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