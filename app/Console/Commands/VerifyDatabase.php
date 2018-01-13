<?php
/**
 * Contains the VerifyDatabase command
 * 
 * PHP Version 7.1
 * 
 * @category ConsoleCommand
 * @package  Photogallery
 * @author   Matthew Stobbs <matthew@sproutingcommunications.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @link     https://github.com/stobbsm/photogallery
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\File;

/**
 * Contains the VerifyDatabase command
 * 
 * @category Class
 * @package  Photogallery
 * @author   Matthew Stobbs <matthew@sproutingcommunications.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @link     https://github.com/stobbsm/photogallery
 */
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
    protected $description = 'Verifies the database integrity';
    
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
        $gallery = Storage::disk('gallery');

        $this->comment("Autofix: " . $autofix);
        $files = File::all();
        if ($files != null) {
            foreach ($files as $file) {
                if (file_exists($file->getFullPath())) {
                    $verified=true;
                    // Set used variables once to speed up allocation.
                    $id = $file->id;
                    $fullpath = $file->getFullPath();
                    $filesize = $gallery->size($file->fullpath);
                    $mimetype = mime_content_type($fullpath);
                    $filetype = filetype($fullpath);
                    $filehash = hash_file('sha256', $fullpath);

                    $this->info(__('cmdline.verify_file', ['filename' => $id]));
                    if ($file->size != $filesize) {
                        $verified=false;
                        $this->comment("File size change -> " . $filesize);
                    }
                    if ($file->mimetype != $mimetype) {
                        $verified=false;
                        $this->comment("Mimetype doesn't match -> " . $mimetype);
                    }
                    if ($file->filetype != $filetype) {
                        $verified=false;
                        $this->comment("Filetype doesn't match -> " . $filetype);
                    }
                    if ($file->checksum != $filehash) {
                        $verified=false;
                        $this->comment("File hash doesn't match -> " . $filehash);
                    }
                    
                    if ($verified) {
                        $this->info("File Verified\n");
                    } else {
                        $this->error("Verfication failed\n");
                        if ($autofix) {
                            $this->line("Attempting to fix: " . $id);
                            $this->call('photogallery:fixfile', ['id' => $id]);
                        } else {
                            $this->info(__('cmdline.nofix'));
                        }
                    }
                } else {
                    $this->error("Can't find file: " . $fullpath);
                    $file->delete();
                }
            }
        } else {
            $this->info(__('cmdline.emptydb'));
        }
    }
}
