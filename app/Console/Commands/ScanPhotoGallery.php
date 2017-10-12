<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Providers\FileBrowserServiceProvider;
use App\File;

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
        printf(__('scanfiles.scanning') . "\n");
        try {
          if(env('GALLERYPATH', false)) {
            $this->filebrowser = resolve('FileBrowser');
            $mediaFiles = $this->filebrowser->SearchMany('mimetype', config('filetypes'))->Flatten(false)->get();
            printf(__('scanfiles.adding') . "\n");
            foreach($mediaFiles as $file) {
              $newfile = File::firstOrNew([
                'filename' => $file['name'],
                'fullpath' => $file['fullpath'],
                'filetype' => $file['filetype'],
                'mimetype' => $file['mimetype'],
                'size' => $file['size']
              ]);
              $newfile->save();
            }
          } else {
            throw new \Exception(__('scanfiles.galleryerror'), E_NOTICE);
          }
        } catch (\Exception $e) {
          printf(__('scanfiles.scanerror', [ "message" => $e->getMessage() ]));
          exit($e->getCode());
        }

    }
}
