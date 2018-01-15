<?php
/**
 * Contains the ImageController class for controlling images.
 *
 * PHP Version 7.1
 *
 * @category HttpRouteController
 * @package  Photogallery
 * @author   Matthew Stobbs <matthew@sproutingcommunications.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GPLv
 * @link     https://github.com/stobbsm/photogallery3
 */

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
use App\Http\Requests\StoreImage;

/**
 * The ImageController class.
 *
 * @category Class
 * @package  Photogallery
 * @author   Matthew Stobbs <matthew@sproutingcommunications.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @link     https://github.com/stobbsm/photogallery
 */
class ImageController extends Controller
{
    protected $dirMode=0775;
    protected $mkdirRecursive=true;

    /**
     * Class constructor
     *
     * Sets the middleware of the class to the 'auth' middleware group.
     */
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
    * @param \Illuminate\Http\Request $request The request object.
    *
    * @return \Illuminate\Http\Response
    */
    public function store(StoreImage $request)
    {
        $user = Auth::user();
        $pathPrefix = Storage::disk('gallery')
            ->getDriver()
            ->getAdapter()
            ->getPathPrefix();
        $path = Storage::disk('gallery')->putFile('uploads', $request->image);
     
        $checksum = hash_file('sha256', $pathPrefix . $path);
        $filename = basename($path);
        $fullpath = $path;
        $filetype = 'file';
        $mimetype = mime_content_type($pathPrefix . $path);
        $size = Storage::disk('gallery')->size($path);

        $file = File::create(
            [
                'filename' => $filename,
                'fullpath' => $path,
                'filetype' => $filetype,
                'mimetype' => $mimetype,
                'size' => $size,
                'checksum' => $checksum,
                'user_id' => $user->id,
            ]
        );

        $file->save();

        return redirect(action('ImageController@edit', ['id' => $file->id]));
    }
    
    /**
    * Display the specified resource.
    *
    * @param int $image The ID of the image to show
    *
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
    * @param int $image The ID of the image edit.
    *
    * @return \Illuminate\Http\Response
    */
    public function edit($image)
    {
        $file = File::find($image);
        $tags = $file->tags()->select('tag')->orderBy('tag')->get();

        // Move tags into an array
        $atags = [];
        foreach ($tags as $tag) {
            array_push($atags, $tag->tag);
        }

        return view('gallery.edit', ["image" => $file, "tags" => $atags]);
    }
    
    /**
    * Update the specified resource in storage.
    *
    * @param \Illuminate\Http\Request $request The request object
    * @param integer                  $id      The ID of the image to update.
    *
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        $file = File::find($id);
        $user = Auth::user();
        $title = ($request->title == null ?
            $file->fileinfo->title : $request->title);
        $desc = ($request->desc == null ?
            $file->fileinfo->desc : $request->desc);
        $tags = $request->tags;

        if ($file->isUnamed()) {
            $file->fileinfo()->create(
                [
                    'title' => $title,
                    'desc' => $desc,
                    'user_id' => $user->id,
                ]
            );
        } else {
            $fileinfo = $file->fileinfo;
            $fileinfo->title = $title;
            $fileinfo->desc = $desc;
            $fileinfo->update();
        }

        $tags = str_replace(' ', '', $tags);
        $tagArray = explode(',', $tags);

        $tagMdlArray = [];

        // Add new tags
        foreach ($tagArray as $addTag) {
            Log::info("Creating new tag: $addTag");
            $tag = Tag::firstOrCreate(['tag' => strtolower($addTag)]);
            array_push($tagMdlArray, $tag->id);
        }
        
        $file->tags()->sync($tagMdlArray);
        
        return redirect(action('ImageController@show', ['id' => $file->id]));
    }
    
    /**
    * Remove the specified resource from storage.
    *
    * @param \App\File $file The File model that needs to be removed.
    *
    * @return \Illuminate\Http\Response
    */
    public function destroy(File $file)
    {
        $path = $file->fullpath;
        Storage::disk('gallery')->delete($path);

        return redirect(action('ImageController@index'));
    }
    
    /**
    * Fetch the contents of the image, suitable for use in a 'src' attribute.
    *
    * @param int $id The ID of the image to fetch
    *
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
    * @param integer $id The ID of the image to download
    *
    * @return \Illuminate\Http\response
    */
    public function download($id)
    {
        $file = File::find($id);
        $filename = $file->fileinfo->title . '_' . $file->filename;
        $filename = str_replace(' ', '_', $filename);
        return response($file->getContents())->
        header('Content-Description', 'File Transfer')->
        header('Content-Disposition', "attachment; filename=" . $filename)->
        header('Content-Transfer-Encoding', 'binary')->
        header('Connection', 'Keep-Alive')->
        header('Content-Type', 'application/octet-stream');
    }
    
    /**
    * Fetch the thumbnail of the image, suitable for use in a 'src' attribute.
    *
    * @param integer $id The ID of the image to get the thumbnail for.
    *
    * @return \Illuminate\Http\response
    */
    public function thumbnail($id)
    {
        $file = File::find($id);
        if ($file->size > 0) {
            return response($file->thumbnail())->
            header('Content-Type', $file->mimetype);
        } else {
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
        foreach ($files as $file) {
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
        foreach ($files as $file) {
            array_push($ids, $file->id);
        }
        $files = File::whereIn('id', $ids)->get();
        return view('gallery.images', ['media' => $files]);
    }
}
