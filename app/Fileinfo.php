<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fileinfo extends Model
{
    protected $table = 'fileinfo';
    
    protected $fillable = [
        'title', 'desc', 'file_id', 'user_id'
    ];
    
    public function file()
    {
        return $this->belongsTo('App\File')->withDefault([
            'title' => 'Untitled',
            'desc' => 'No Description',
        ]);
    }
}
    