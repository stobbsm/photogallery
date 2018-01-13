<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fileinfo extends Model
{
    protected $table = 'fileinfo';
    
    protected $fillable = [
        'title', 'desc', 'file_id', 'user_id'
    ];
    
    /**
     * Return the file attached to the fileinfo.
     */
    public function file()
    {
        return $this->belongsTo('App\File')->withDefault([
            'title' => 'Untitled',
            'desc' => 'No Description',
        ]);
    }

    /**
     * Get the tags attached to fileinfo's file.
     */
    public function tags()
    {
        return $this->hasManyThrough('App\Tag', 'App\File');
    }
}
