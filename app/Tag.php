<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [ 'tag' ];

    /**
     * Get all the files with this tag.
     */
    public function files()
    {
        return $this->belongsToMany('App\File', 'file_tag', 'tag_id', 'file_id');
    }

    /**
     * Get all the fileinfo for the tags.
     */
    public function fileinfo()
    {
        return $this->hasManyThrough('App\Fileinfo', 'App\File');
    }
}
