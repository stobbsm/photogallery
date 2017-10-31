<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\File;

class GenerateThumbnails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'photogallery:generatethumbnails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Thumbnails for the application.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        printf("Generating Thumbnails\n");
        $files = File::all();
        foreach ($files as $file) {
            $cache_path = storage_path() . '/imagecache';
            $cache_file = $cache_path . '/' . $file->checksum;
            if (file_exists($cache_file)) {
                printf("Removing existing thumbnail\n");
                unlink($cache_file);
            }
            if (!file_exists($cache_path)) {
                mkdir($cache_path);
            }
            $max_width = 100;
            $max_height = 100;
            list($width, $height) = getimagesize($file->fullpath);
            $ratio = $width / $height;

            if ($max_width/$max_height > $ratio) {
                $new_width = $max_height*$ratio;
                $new_height = $max_height;
            } else {
                $new_height = $max_width/$ratio;
                $new_width = $max_width;
            }

            switch ($file->mimetype) {
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
                throw new Exception('Unknown image type: '.$file->mimetype);
                break;
            }
            try {
                $original = @$image_create_func($file->fullpath);
                if (!$original) {
                    $original = imagecreatefromstring(file_get_contents($file->fullpath));
                }
                $tmp = imagecreatetruecolor($new_width, $new_height);
                imagecopyresampled($tmp, $original, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

                $image_save_func($tmp, $cache_file);
            } catch (ErrorException $e) {
                printf("Error: %s\n", $e->getMessage());
            }
        }
    }
}
