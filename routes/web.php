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

Route::get('/', function() {
  if (Auth::check()) {
    return redirect('/home');
  }
  return redirect('/welcome');
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/tools/scanfiles', function () {
    return view('tools.scanfiles');
});

Route::get('/tools/verifydb', function () {
    return view('tools.verify');
});

Route::get('/gallery', function () {
    $media = App\File::all();
    return view('gallery.images', ["media" => $media]);
});

Route::get('/show/{id}', function ($id) {
    $image = App\File::find($id);
    return view('gallery.image', ["image" => $image]);
});

Route::get('/image/{id}', function ($id) {
    $image = App\File::find($id);
    return response($image->getContents())->
            header('Content-Type', $image->mimetype);
});

Route::get('/image/{id}/download', function ($id) {
  $image = App\File::find($id);
  return response($image->getContents())->
          header('Content-Description', 'File Transfer')->
          header('Content-Disposition', "attachment; filename=" . $image->filename)->
          header('Content-Transfer-Encoding', 'binary')->
          header('Connection', 'Keep-Alive')->
          header('Content-Type', 'application/octet-stream');
});

Route::get('/image/thumbnail/{id}', function ($id) {
    $image = App\File::find($id);
    if ($image->size > 0) {
        return response($image->thumbnail())->
              header('Content-Type', $image->mimetype);
    }
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resources([
  'users' => 'UserController',

]);
