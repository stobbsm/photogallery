<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\File;

class VerifyDatabase extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'photogallery:verifydatabase';
    
    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Verifies the database integrity, and cleans it up if needed.';
    
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
        printf(__('cmdline.title_verify') . PHP_EOL);
        $files = File::all();
        if ($files != null) {
            foreach ($files as $file) {
                if (file_exists($file->fullpath)) {
                    $verified=true;
                    printf("Verfying file: %s -> ", $file->fullpath);
                    if ($file->size != filesize($file->fullpath)) {
                        $verified=false;
                        printf("File size change -> ");
                    }
                    if ($file->mimetype != mime_content_type($file->fullpath)) {
                        $verified=false;
                        printf("Mimetype doesn't match -> ");
                    }
                    if ($file->filetype != filetype($file->fullpath)) {
                        $verified=false;
                        printf("Filetype doesn't match -> ");
                    }
                    if ($file->checksum != hash_file('sha256', $file->fullpath)) {
                        $verified=false;
                        printf("File hash doesn't match -> ");
                    }
                    
                    if ($verified) {
                        printf("File Verified\n");
                    } else {
                        printf("Verfication failed\n");
                    }
                } else {
                    printf("Can't find file: %s\n", $file->fullpath);
                    $file->delete();
                }
            }
        } else {
            printf(__('cmdline.emptydb') . PHP_EOL);
        }
    }
}
