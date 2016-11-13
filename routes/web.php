<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::resource('/', 'HomeController');
Route::resource('news', 'NewsController');
Route::resource('magazines', 'MagazinesController');

Route::get('videos/vCollect', 'VideosController@vCollect');
Route::resource('videos', 'VideosController');
Route::resource('ebook', 'EbookController');

Route::auth();

/**
 * 禁止註冊
 */
// 如果走頁面的點擊註冊就導到登入頁面
Route::get("register", function() {
    return redirect("login");
});

// 如果走POST註冊就不理他
Route::post("register", function() {
    return;
});

Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin', 
    'middleware' => 'auth',
], function() {

    Route::put('carousels/order', 'CarouselsController@order');
    Route::resource('carousels', 'CarouselsController');
    Route::resource('news', 'NewsController');
    Route::resource('magazines', 'MagazinesController');
    Route::resource('videos', 'VideosController');
    Route::resource('users', 'UsersController');
    Route::resource('system', 'SystemController');
});

Route::get('/home', 'HomeController@index');

Route::get('/auth/google', 'Auth\GoogleController@redirect');
Route::get('/auth/google/callback', 'Auth\GoogleController@callback');

Auth::routes();