<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
      'filename', 'fullpath', 'filetype', 'mimetype', 'size'
    ];

    public function tags() {
      return $this->belongsToMany('App\Tag');
    }

    public function loadData() {
      $handle = fopen($this->fullpath, "rb");
      $contents = fread($handle, $this->size);
      fclose($handle);

      return $contents;
    }
}
