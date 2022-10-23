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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function() {
    // ユーザ関連
    Route::resource('users', 'App\Http\Controllers\UsersController', ['only' => ['index', 'show', 'edit', 'update']]);

    // フォロー/フォロー解除を追加
    Route::post('users/{id}/follow', 'App\Http\Controllers\UsersController@follow')->name('follow');
    Route::delete('users/{id}/unfollow', 'App\Http\Controllers\UsersController@unfollow')->name('unfollow');

    // ツイート関連
    Route::resource('tweets', 'App\Http\Controllers\TweetsController', ['only' => ['index', 'create', 'create2', 'store', 'show', 'edit', 'update', 'destroy']]);
    Route::get('/search','App\Http\Controllers\TweetsController@create2');

    // コメント関連
    Route::resource('comments', 'App\Http\Controllers\CommentsController', ['only' => ['store']]);

    // いいね関連
    Route::resource('favorites', 'App\Http\Controllers\FavoritesController', ['only' => ['store', 'destroy']]);

    // ユーザ退会
Route::delete('user/delete/{user}', [App\Http\Controllers\UsersController::class, 'delete'])->name('users.delete');
Route::get('user/{user}', 'App\Http\Controllers\UsersController@show');

});

// システム管理者のみ
Route::group(['middleware' => ['auth', 'can:system-only']], function () {
 // ユーザ削除
 Route::delete('user/{user}', [App\Http\Controllers\UsersController::class, 'destroy'])->name('users.destroy');
 Route::get('/user/{user}', 'App\Http\Controllers\UsersController@shows');
});
