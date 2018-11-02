<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
use App\Tag;
use App\Fileinfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = File::all()->count();
        $tags = Tag::all()->count();
        $untagged = DB::table('files')
            ->select('files.id')
            ->leftJoin('file_tag', 'files.id', '=', 'file_tag.file_id')
            ->whereRaw('file_tag.tag_id is null')
            ->count();
        $untitled = DB::table('files')
            ->select('files.id')
            ->leftJoin('fileinfo', 'files.id', '=', 'fileinfo.file_id')
            ->whereRaw('fileinfo.id is null')
            ->count();
        $userid = Auth::user()->id;
        $userfiles = DB::table('files')
            ->select('files.id')
            ->where('files.user_id', '=', $userid)
            ->count();
        
        // Test encryption with username
        $key = Crypt::decryptString(Cookie::get('key'));

        return view(
            'home', 
            [
                'files' => $files,
                'tags' => $tags,
                'untagged' => $untagged,
                'untitled' => $untitled,
                'userfiles' => $userfiles,
                'key' => $key,
            ]
        );
    }
}
