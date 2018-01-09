<?php

namespace App\Http\Controllers;

use App\File;
use App\User;
use App\Fileinfo;
use App\Tag;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller
{
    protected $dirMode=0775;
    protected $mkdirRecursive=true;

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
        $media = File::paginate(9);
        return view('gallery.images', ["media" => $media]);
    }
    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        Log::info("Entered ImageController@create");
        $maxsize=ini_get('upload_max_filesize');
        return view('gallery.upload', ['maxsize' => $maxsize]);
    }
    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $user = Auth::user();
        $pathPrefix = Storage::disk('gallery')->getDriver()->getAdapter()->getPathPrefix();
        $path = Storage::disk('gallery')->putFile('uploads', $request->image);
        
        $filename = basename($path);
        $fullpath = $path;
        $filetype = 'file';
        $mimetype = mime_content_type($pathPrefix . $path);
        $size = Storage::disk('gallery')->size($path);
        $checksum = hash_file('sha256', $pathPrefix . $path);

        $file = File::create([
            'filename' => $filename,
            'fullpath' => $path,
            'filetype' => $filetype,
            'mimetype' => $mimetype,
            'size' => $size,
            'checksum' => $checksum,
        ]);

        $file->save();

        return redirect(action('ImageController@edit', ['id' => $file->id]));
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
        $tags = $file->tags()->select('tag')->orderBy('tag')->get();

        // Move tags into an array
        $atags = [];
        foreach($tags as $tag) {
            array_push($atags, $tag->tag);
        }

        return view('gallery.edit', ["image" => $file, "tags" => $atags]);
    }
    
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        $file = File::find($id);
        $user = Auth::user();
        $title = ($request->title == null ? $file->fileinfo->title : $request->title);
        $desc = $request->desc;
        $tags = $request->tags;

        $file->fileinfo()->create([
            'title' => $title,
            'desc' => $desc,
            'user_id' => $user->id,
        ]);

        $tags = str_replace(' ', '', $tags);
        $tagArray = explode(',', $tags);

        $tagMdlArray = [];

        // Add new tags
        foreach($tagArray as $addTag) {
            Log::info("Creating new tag: $addTag");
            $tag = Tag::firstOrCreate(['tag' => strtolower($addTag)]);
            array_push($tagMdlArray, $tag->id);
        }
        
        $file->tags()->sync($tagMdlArray);
        
        return view('gallery.image', ["image" => $file]);
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
        header('Content-Disposition', "attachment; filename=" . str_replace(' ', '_', $file->fileinfo->title . '_' . $file->filename))->
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

    /**
     * Fetch all the files that are missing a title for editing.
     * 
     * @return \Illuminate\Http\response
     */
    public function notitle()
    {
        $files = DB::table('files')
            ->select('files.id')
            ->leftJoin('fileinfo', 'files.id', '=', 'fileinfo.file_id')
            ->whereRaw('fileinfo.id is null')
            ->limit(9)
            ->get();

        $ids = [];
        foreach($files as $file) {
            array_push($ids, $file->id);
        }
        $files = File::whereIn('id', $ids)->get();
        return view('gallery.images', ['media' => $files]);
    }

    /**
     * Fetch all the files that are missing tags.
     * 
     * @return \Illuminate\Http\response
     */
    public function notags()
    {
        $files = DB::table('files')
            ->select('files.id')
            ->leftJoin('file_tag', 'files.id', '=', 'file_tag.file_id')
            ->whereRaw('file_tag.tag_id is null')
            ->limit(9)
            ->get();

        $ids = [];
        foreach($files as $file) {
            array_push($ids, $file->id);
        }
        $files = File::whereIn('id', $ids)->get();
        return view('gallery.images', ['media' => $files]);
    }
}
