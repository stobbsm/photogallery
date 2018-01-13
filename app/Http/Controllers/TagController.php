<?php
/**
 * Contains the TagController class for controlling tagging.
 *
 * PHP Version 7.1
 *
 * @category HttpRouteController
 * @package  Photogallery
 * @author   Matthew Stobbs <matthew@sproutingcommunications.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @link     https://github.com/stobbsm/photogallery
 */

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

/**
 * TagController Class
 *
 * @category Class
 * @package  Photogallery
 * @author   Matthew Stobbs <matthew@sproutingcommunications.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @link     https://github.com/stobbsm/photogallery
 */
class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::orderBy('tag')->get();
        return view('tags.tags', ['tags' => $tags]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->action('TagController@index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request The request object
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect()->action('TagController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Tag $tag The required Tag model
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        $files = $tag->files()->paginate(9);
        return view('tags.images', ['files' => $files, 'tagname' => $tag->tag]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Tag $tag The required Tag model
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return redirect()->action('TagController@index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request The request object
     * @param \App\Tag                 $tag     The required Tag model
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        return redirect()->action('TagController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Tag $tag The required Tag model
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        return redirect()->action('TagController@index');
    }
}
