<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\TagController;
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

Route::group(['prefix' => 'dashboard'], function () {
    Route::group(['prefix' => 'statistical'], function () {
        Route::get('', 'App\Http\Controllers\Admin\StatisticalController@index');
    });
    Route::group(['prefix' => 'posts'], function () {
        Route::get('', 'App\Http\Controllers\Admin\PostController@index');
    });
    Route::group(['prefix' => 'post-statuses'], function () {
        Route::get('', 'App\Http\Controllers\Admin\PostStatusController@index');
        Route::post('', 'App\Http\Controllers\Admin\PostStatusController@store');
        Route::put('{id}', 'App\Http\Controllers\Admin\PostStatusController@update');
        Route::delete('{id}', 'App\Http\Controllers\Admin\PostStatusController@destroy');
    });
});

Route::group(['prefix' => 'reports'], function () {
    Route::get('', 'App\Http\Controllers\ReportController@index');
    Route::post('', 'App\Http\Controllers\ReportController@store');
    Route::delete('{id}', 'App\Http\Controllers\ReportController@destroy');
});


Route::get('/search', 'App\Http\Controllers\SearchController@search');

// Get user by id
Route::group(['prefix' => 'user-detail'], function () {
    Route::get('{id}', 'App\Http\Controllers\UserController@show');
});

Route::group(['prefix' => 'notifications'], function () {
    Route::get('get-all', 'App\Http\Controllers\NotificationController@getAll');
    Route::put('read-notice/{id}', 'App\Http\Controllers\NotificationController@readNotice');
    Route::put('read-all-notice/{user_id}', 'App\Http\Controllers\NotificationController@readAllNotice');
    Route::post('get-user', 'App\Http\Controllers\NotificationController@getUser');
    Route::post('my-notice', 'App\Http\Controllers\NotificationController@myNotice');
    Route::post('all-my-notice', 'App\Http\Controllers\NotificationController@allMyNotice');
    Route::post('send-all', 'App\Http\Controllers\NotificationController@sendAll');
    Route::post('send-users', 'App\Http\Controllers\NotificationController@sendUsers');
    Route::post('send', 'App\Http\Controllers\NotificationController@send');
});

// followed-tags api
Route::group(['prefix' => 'followed-tags'], function () {
    Route::get('', 'App\Http\Controllers\FollowedTagController@index');//lấy ra những tags đã followed
    Route::get('{id}', 'App\Http\Controllers\FollowedTagController@getFollowedTagById');//lấy ra tag hiện tại đã follow hay chưa 
    Route::post('', 'App\Http\Controllers\FollowedTagController@store');//followed
    Route::delete('', 'App\Http\Controllers\FollowedTagController@destroy');//unfollowed
});

// posts api
Route::group(['prefix' => 'posts'], function () {
    Route::get('', 'App\Http\Controllers\PostController@index');
    Route::get('{id}', 'App\Http\Controllers\PostController@show');
    Route::get('list-post-user/{id}', 'App\Http\Controllers\PostController@getPostByUser');
    Route::post('', 'App\Http\Controllers\PostController@store');
    Route::put('{id}', 'App\Http\Controllers\PostController@update');
    Route::delete('{id}', 'App\Http\Controllers\PostController@destroy');
    Route::post('draft', 'App\Http\Controllers\PostController@draftPost');
    Route::get('draft/{id_user}', 'App\Http\Controllers\PostController@getDraftPostByUser');
    Route::put('draft/{id_post}', 'App\Http\Controllers\PostController@updateDraftPost');
    Route::get('search/draft/{id_user}', 'App\Http\Controllers\PostController@searchDraftPost');
    // Interactions
    Route::get('interactions/views', 'App\Http\Controllers\InteractionController@incrementViews');
    Route::post('interactions/liked', 'App\Http\Controllers\InteractionController@liked');

});

Route::group(['prefix' => 'comments'], function () {
    Route::post('', 'App\Http\Controllers\CommentController@store');
    Route::put('{comment}', 'App\Http\Controllers\CommentController@update');
    Route::delete('{comment}', 'App\Http\Controllers\CommentController@destroy');
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

// questions api
Route::group(['prefix' => 'questions'], function () {
    Route::get('', 'App\Http\Controllers\QuestionController@index');
    Route::get('{id}', 'App\Http\Controllers\QuestionController@show');
    Route::get('list-question-user/{id}', 'App\Http\Controllers\QuestionController@getQuestionByUser');
    Route::post('', 'App\Http\Controllers\QuestionController@store');
    Route::put('{id}', 'App\Http\Controllers\QuestionController@update');
    Route::delete('{id}', 'App\Http\Controllers\QuestionController@destroy');
    Route::post('draft', 'App\Http\Controllers\QuestionController@draftQuestion');
    Route::get('draft/{id_user}', 'App\Http\Controllers\QuestionController@getDraftQuestionByUser');
    Route::put('draft/{id_question}', 'App\Http\Controllers\QuestionController@updateDraftQuestion');
    Route::get('search/draft/{id_user}', 'App\Http\Controllers\QuestionController@searchDraftQuestion');
    // Interactions
    Route::get('interactions/views', 'App\Http\Controllers\QuestionInteractionController@incrementViews');
    Route::post('interactions/liked', 'App\Http\Controllers\QuestionInteractionController@liked');
});

Route::group(['prefix' => 'answers'], function () {
    Route::post('', 'App\Http\Controllers\AnswerController@store');
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

//! API QUẢN LÍ CÁC THẺ CỦA ADMIN
Route::group(['prefix' => 'admin/tags'], function () {
    Route::get('', [TagController::class, 'index']);
    Route::get('{id_tag}', [TagController::class, 'show']);
    Route::post('', [TagController::class, 'store']);
    Route::delete('{id_tag}', [TagController::class, 'destroy']);
    Route::put('{id_tag}', [TagController::class, 'update']);
});





