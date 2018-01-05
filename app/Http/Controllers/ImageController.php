<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $media = File::all();
        return view('gallery.images', ["media" => $media]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('gallery.upload');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        return view('gallery.edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $image
     * @return \Illuminate\Http\Response
     */
    public function show($image)
    {
        $file = File::find($image);
        return view('gallery.image', ["image" => $file]);
    }

    /**
     * Show the form for editing the specified resource.
     * This is for updating tag data and user generated metadata.
     *
     * @param  int $image
     * @return \Illuminate\Http\Response
     */
    public function edit($image)
    {
        $file = File::find($image);
        return view('gallery.edit', ["image" => $file]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        //
    }

    /**
     * Fetch the contents of the image, suitable for use in a 'src' attribute.
     *
     * @param int $id
     * @return \Illuminate\Http\response
     */
    public function fetch($id)
    {
        $file = File::find($id);
        return response($file->getContents())->
                header('Content-Type', $file->mimetype);
    }

    /**
     * Fetch the contents of the image, as a file download.
     *
     * @param int $id
     * @return \Illuminate\Http\response
     */
    public function download($id)
    {
        $file = File::find($id);
        return response($file->getContents())->
                header('Content-Description', 'File Transfer')->
                header('Content-Disposition', "attachment; filename=" . $file->filename)->
                header('Content-Transfer-Encoding', 'binary')->
                header('Connection', 'Keep-Alive')->
                header('Content-Type', 'application/octet-stream');
    }

    /**
     * Fetch the thumbnail of the image, suitable for use in a 'src' attribute.
     *
     * @param int $id
     * @return \Illuminate\Http\response
     */
    public function thumbnail($id)
    {
        $file = File::find($id);
        if ($file->size > 0) {
            return response($file->thumbnail())->
                    header('Content-Type', $file->mimetype);
        }
        else {
            abort(404);
        }
    }
}
