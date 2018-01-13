<?php
/**
 * Contains the GenerateThumbnails artisan command for
 * pre-generating thumbnails after a scan.
 * 
 * PHP Version 7.1
 * 
 * @category Command
 * @package  Photogallery
 * @author   Matthew Stobbs <matthew@sproutingcommunications.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @link     https://github.com/stobbsm/photogallery
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\File;

/**
 * Contains the GenerateThumbnails command.
 * 
 * @category Class
 * @package  Photogallery
 * @author   Matthew Stobbs <matthew@sproutingcommunications.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @link     https://github.com/stobbsm/photogallery
 */
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
        $this->line("Generating Thumbnails\n");
        $files = File::all();
        foreach ($files as $file) {
            try {
                $this->comment('Generating thumbnail for ' . $file->filename);
                $file->thumbnail();
            } catch (\Exception $e) {
                $this->error('Error generating thumbnail');
            }
        }
    }
}
