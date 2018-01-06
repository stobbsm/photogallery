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
    protected $signature = 'photogallery:verifydatabase
                                                        {--autofix : Attempt to fix any errors}';
    
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
        $autofix = $this->option('autofix');
        $this->line(__('cmdline.title_verify'));

        $this->comment("Autofix: " . $autofix);
        $files = File::all();
        if ($files != null) {
            foreach ($files as $file) {
                if (file_exists($file->fullpath)) {
                    $verified=true;
                    $this->info(__('cmdline.verify_file', ['filename' => $file->id]));
                    if ($file->size != filesize($file->fullpath)) {
                        $verified=false;
                        $this->comment("File size change -> " . filesize($file->fullpath));
                    }
                    if ($file->mimetype != mime_content_type($file->fullpath)) {
                        $verified=false;
                        $this->comment("Mimetype doesn't match -> " . mime_content_type($file->fullpath));
                    }
                    if ($file->filetype != filetype($file->fullpath)) {
                        $verified=false;
                        $this->comment("Filetype doesn't match -> " . filetype($file->fullpath));
                    }
                    $filehash = hash_file('sha256', $file->fullpath);
                    if ($file->checksum != $filehash) {
                        $verified=false;
                        $this->comment("File hash doesn't match -> " . $filehash);
                    }
                    
                    if ($verified) {
                        $this->info("File Verified\n");
                    } else {
                        $this->error("Verfication failed\n");
                        if($autofix) {
                            $this->line("Attempting to fix: " . $file->id);
                            $this->call('photogallery:fixfile', ['id' => $file->id]);
                        } else {
                            $this->info("Not attempting to fix. Set autofix to 'true' to fix");
                        }
                    }
                } else {
                    $this->error("Can't find file: " . $file->fullpath);
                    $file->delete();
                }
            }
        } else {
            $this->info(__('cmdline.emptydb'));
        }
    }
}
