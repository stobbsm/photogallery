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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/scangallery', function () {
  return view('scanfiles');
});

Route::get('/showgallery', function () {
  $media = App\File::all();
  return view('gallery.images', ["media" => $media]);
});

Route::get('/image/{id}', function ($id) {
  $image = App\File::find($id);
  return response($image->getContents())->
            header('Content-Type', $image->mimetype);
});
