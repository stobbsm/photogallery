<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [ 'tag' ];

    public function files()
    {
        return $this->belongsToMany('App\File', 'file_tag', 'tag_id', 'file_id');
    }
}
