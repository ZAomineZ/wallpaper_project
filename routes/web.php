<?php

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

Route::get('/', 'PagesController@index')->name('home');
Route::get('/Wallpaper', 'PagesController@wallpaper')->name('wallpaper');
Route::get('/category', 'PagesController@category')->name('category');
Route::get('/Admin', 'PagesController@Admin')->name('Admin');
Route::get('/Search', 'PagesController@Search')->name('search');
Route::get('/PostSearch', 'PagesController@PostSearch')->name('PostSearch');
Route::get('/LogPage', 'PagesController@LogPage')->name('LogPage');
Route::post('/picture/{id}', 'ActionPost@PostAction');
Route::get('/UserSetting/{id}', 'PagesController@UserProfile')->name('User');
Route::post('/UserSetting/{id}', 'ActionPost@Follow')->name('follow');

Route::get('/phpinfo', function() {
    return view('phpinfo');
});

Route::resource('picture', 'PostController');
Route::resource('cat', 'CategoryController');
Route::resource('settings', 'MySettingController');

Auth::routes();
