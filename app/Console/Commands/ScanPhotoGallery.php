<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Providers\FileBrowserServiceProvider;

class ScanPhotoGallery extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'photogallery:scan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan the photogallery and build a database';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        printf("Scanning the photo library...\n");
        try {
          if(env('GALLERYPATH', false)) {
            $this->filebrowser = resolve('FileBrowser');
            print_r($this->filebrowser->flatten(false));
          } else {
            throw new \Exception("You must set GALLERYPATH in your env", E_NOTICE);
          }
        } catch (\Exception $e) {
          printf("Scan failed: %s\n", $e->getMessage());
          exit($e->getCode());
        }

    }
}
