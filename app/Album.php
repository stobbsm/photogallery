<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = [
        'name', 'desc', 'user_id'
    ];

    /**
     * An Album contains many files
     *
     * @return \App\File Collection of Files belonging to this album
     */
    public function files()
    {
        return $this->hasMany('App\File');
    }

    /**
     * An album is owned by one user
     *
     * @return \App\User The user that this album belongs to
     */
    public function user()
    {
        return $this->hasOne('App\User');
    }
}
