<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'blog'], function () {
    Route::get('/', 'App\Http\Controllers\PostController@index');
    Route::get('/post/{slug}', 'App\Http\Controllers\PostController@single');
});

Auth::routes();

Route::group(['prefix' => 'admin'], function () {
    Route::group(['prefix' => 'blog'], function () {
        Route::get('/post', 'App\Http\Controllers\PostController@create');
        Route::post('/post', 'App\Http\Controllers\PostController@save');
        Route::get('/post/{slug}', 'App\Http\Controllers\PostController@edit');
        Route::put('/post/{slug}', 'App\Http\Controllers\PostController@update');
    
        Route::post('/comment', 'App\Http\Controllers\CommentController@save');
    });
});
