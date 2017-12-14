<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
      'filename', 'fullpath', 'filetype', 'mimetype', 'size', 'checksum'
    ];

    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'file_tag', 'file_id', 'tag_id');
    }

    public function fileinfo()
    {
        return $this->hasOne('App\Fileinfo')->withDefault([
            'title' => "Untitled",
            'desc' => "No Description",
        ]);
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function loadData()
    {
        $base64_img_contents = base64_encode($this->getContents());

        return $base64_img_contents;
    }

    public function getContents()
    {
        return file_get_contents($this->fullpath);
    }

    public function thumbnail()
    {
        $cache_path = storage_path() . '/imagecache';
        $cache_file = $cache_path . '/' . $this->checksum;
        if (!file_exists($cache_file)) {
            if (!file_exists($cache_path)) {
                mkdir($cache_path);
            }
            $max_width = ENV('THUMBNAIL_SIZE', 256);
            $max_height = ENV('THUMBNAIL_SIZE', 256);
            list($width, $height) = getimagesize($this->fullpath);
            $ratio = $width / $height;

            if ($max_width/$max_height > $ratio) {
                $new_width = $max_height*$ratio;
                $new_height = $max_height;
            } else {
                $new_height = $max_width/$ratio;
                $new_width = $max_width;
            }

            switch ($this->mimetype) {
          case 'image/jpeg':
          case 'image/jpg':
            $image_create_func = 'imagecreatefromjpeg';
            $image_save_func = 'imagejpeg';
            break;

          case 'image/png':
            $image_create_func = 'imagecreatefrompng';
            $image_save_func = 'imagepng';
            break;

          case 'image/gif':
            $image_create_func = 'imagecreatefromgif';
            $image_save_func = 'imagegif';
            break;

          default:
            throw new Exception('Unknown image type: '.$this->mimetype);
            break;
        }
            $original = $image_create_func($this->fullpath);
            $tmp = imagecreatetruecolor($new_width, $new_height);
            imagecopyresampled($tmp, $original, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

            $image_save_func($tmp, $cache_file);
        }
        return file_get_contents($cache_file);
    }
}
