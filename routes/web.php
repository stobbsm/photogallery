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

Route::get('/', 'GuestController@index');
Route::get('/welcome', 'GuestController@welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Logout route binding
Route::get('/logout', 'Auth\LoginController@logout');

// Tools routes
Route::get('/tools/scanfiles', 'Tools@scanfiles');
Route::get('/tools/verifydb', 'Tools@verifydb');

// Specialized Image routes
Route::get('/gallery', 'ImageController@index');
Route::get('/image/{id}/fetch', 'ImageController@fetch')->name('image.fetch');
Route::get('/image/{id}/download', 'ImageController@download')->name('image.download');
Route::get('/image/{id}/thumbnail', 'ImageController@thumbnail')->name('image.thumbnail');
Route::get('/image/untitled', 'ImageController@notitle')->name('image.notitle');
Route::get('/image/untagged', 'ImageController@notags')->name('image.notags');

Route::resources([
  'users' => 'UserController',
  'image' => 'ImageController',
  'tag' => 'TagController',
]);
