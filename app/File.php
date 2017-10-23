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
      $base64_img_contents = base64_encode($this->getContents());

      return $base64_img_contents;
    }

    public function getContents() {
      return file_get_contents($this->fullpath);
    }

    public function thumbNail() {
      $file_contents = $this->getContents();
      $b64_image = base64_encode($file_contents);
    }
}
