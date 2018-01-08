<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'filename', 'fullpath', 'filetype', 'mimetype', 'size', 'checksum'
    ];
    
    /**
    * File can only belong to one user
    *
    * @return App\User object of the owning user
    */
    public function user()
    {
        return $this->hasOne('App\User');
    }
    
    /**
    * File can have many tags, and tags can belong to many files
    *
    * @return \App\Tag[] object containg tags
    */
    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'file_tag', 'file_id', 'tag_id');
    }
    
    /**
    * File can have only one FileInfo type
    *
    * @return App\Fileinfo object containg editable metadata
    */
    public function fileinfo()
    {
        return $this->hasOne('App\Fileinfo')->withDefault([
            'title' => "Untitled",
            'desc' => "No Description",
        ]);
    }
        
    /**
    * File can have many comments
    *
    * @return \App\Comment[] object containg comments for the file
    */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
        
    /**
    * getContents returns the contents of the file
    *
    * @return string|bool Contents of the file, or false on failure
    */
    public function getContents()
    {
        return file_get_contents($this->fullpath);
    }
    
    /**
     * isUnamed determines if the file's fileinfo has a title element set
     * 
     * @return bool true|false
     */
    public function isUnamed()
    {
        return $this->fileinfo->title == "Untitled";
    }

    /**
     * isUnTagged determines if the file has any tags
     */
    public function isUnTagged()
    {
        return $this->tags()->count() == 0;
    }

    /**
    * thumbnail returns the content of the given file after generating a thumbnail (if it needs to).
    *
    * @return string|bool Contents of the file or false on failure
    */
    public function thumbnail()
    {
        $cache_path = storage_path() . '/imagecache';
        $cache_file = $cache_path . '/' . $this->checksum;
        if (!file_exists($cache_file)) {
            if (!file_exists($cache_path)) {
                mkdir($cache_path);
            }
            $max_width = env('THUMBNAIL_SIZE', 256);
            $max_height = env('THUMBNAIL_SIZE', 256);
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
        