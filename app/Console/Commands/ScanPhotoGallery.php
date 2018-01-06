<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Providers\FileBrowserServiceProvider;
use App\File;

class ScanPhotoGallery extends Command
{
    /**
    * The name and signature of the console command.
    * @var string
    *
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
        $fileDifference = false;
        printf(__('cmdline.title_scan') . "\n");
        try {
            if (env('GALLERYPATH', false)) {
                $this->filebrowser = resolve('FileBrowser');
                $mediaFiles = $this->filebrowser->SearchMany('mimetype', config('filetypes'))->Flatten(false)->get();
                
                foreach ($mediaFiles as $file) {
                    $filehash = hash_file('sha256', $file['fullpath']);
                    
                    try {
                        printf(__('cmdline.status_verify_file') . ": %s -> ", $file['name']);
                        $oldfile = File::where('checksum', $filehash)->first();
                        
                        if ($oldfile == null) {
                            throw new \Exception(__('cmdline.status_scan_filenotexist'), E_NOTICE);
                        } else {
                            printf(__('cmdline.exists') . PHP_EOL);
                        }
                    } catch (\Exception $e) {
                        printf($e->getMessage() . ' -> ');
                        
                        $newfile = File::firstOrNew([
                            'filename' => $file['name'],
                            'fullpath' => $file['fullpath'],
                            'filetype' => $file['filetype'],
                            'mimetype' => $file['mimetype'],
                            'size' => $file['size'],
                            'checksum' => $filehash
                        ]);
                        $newfile->save();
                        printf(__('cmdline.added'). PHP_EOL);
                    }
                }
            } else {
                throw new \Exception(__('cmdline.galleryerror'), E_NOTICE);
            }
        } catch (\Exception $e) {
            printf(__('cmdline.scanerror', [ "message" => $e->getMessage() ]));
            exit($e->getCode());
        }
    }
}
    