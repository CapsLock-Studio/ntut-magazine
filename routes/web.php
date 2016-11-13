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

use App\Http\Middleware\ActiveUser;

Route::resource('/', 'HomeController');
Route::resource('news', 'NewsController');
Route::resource('magazines', 'MagazinesController');

Route::get('videos/vCollect', 'VideosController@vCollect');
Route::resource('videos', 'VideosController');
Route::resource('ebook', 'EbookController');

Route::auth();

Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => [ ActiveUser::class, 'auth' ],
], function() {
    Route::resource('/', 'CarouselsController');

    Route::put('carousels/order', 'CarouselsController@order');
    Route::resource('carousels', 'CarouselsController');
    Route::resource('news', 'NewsController');
    Route::resource('magazines', 'MagazinesController');
    Route::resource('videos', 'VideosController');

    Route::get('users/setting', 'UsersController@setting');
    Route::put('users/update-setting', 'UsersController@updateSetting');
    Route::resource('users', 'UsersController');
    Route::resource('system', 'SystemController');
});

Route::get('/home', 'HomeController@index');

Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/auth/google', 'Auth\GoogleController@redirect');
Route::get('/auth/google/callback', 'Auth\GoogleController@callback');

Auth::routes();