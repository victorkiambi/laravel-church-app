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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix' => 'v1'], function () {
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('register', 'App\Http\Controllers\AuthController@register');
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group( [ 'prefix' => 'v1' ], function () {
        Route::get('logout', 'App\Http\Controllers\AuthController@logout');
        Route::get('user', 'App\Http\Controllers\AuthController@user');
        Route::get( 'posts', 'App\Http\Controllers\PostController@index' );
        Route::get( 'posts/{id}', 'App\Http\Controllers\PostController@show' );
        Route::post( 'posts', 'App\Http\Controllers\PostController@store' );
        Route::put( 'posts/{id}', 'App\Http\Controllers\PostController@update' );
        Route::delete( 'posts/{id}', 'App\Http\Controllers\PostController@destroy' );

        Route::get( 'comments', 'App\Http\Controllers\CommentController@index' );
        Route::get( 'comments/{id}', 'App\Http\Controllers\CommentController@show' );
        Route::post( 'comments', 'App\Http\Controllers\CommentController@store' );
        Route::put( 'comments/{id}', 'App\Http\Controllers\CommentController@update' );
        Route::delete( 'comments/{id}', 'App\Http\Controllers\CommentController@destroy' );

        Route::get( 'app-users', 'App\Http\Controllers\AppUserController@index' );
        Route::get( 'app-users/{id}', 'App\Http\Controllers\AppUserController@show' );
        Route::post( 'app-users', 'App\Http\Controllers\AppUserController@store' );
        Route::put( 'app-users/{id}', 'App\Http\Controllers\AppUserController@update' );
        Route::delete( 'app-users/{id}', 'App\Http\Controllers\AppUserController@destroy' );
    });
});

