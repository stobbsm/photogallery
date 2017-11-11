<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'comment'
    ];

    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function file()
    {
        return $this->hasOne('App\File');
    }
}
