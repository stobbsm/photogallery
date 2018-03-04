<?php
/**
 * Contains the CleanAll artisan command.
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
use App\File;

/**
 * CleanAll artisan command.
 *
 * @category Class
 * @package  Photogallery
 * @author   Matthew Stobbs <matthew@sproutingcommunications.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @link     https://github.com/stobbsm/photogallery
 */
class CleanAll extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'photogallery:cleanall
                                {--force : Remove all files}';
    
    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Verify the database, and clean the thumbnail cache.';
    
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
        $force = $this->option('force');
        $this->info("Building filelist in the imagecache...");
        
        $inUseMap = [];
        $files = File::all();
        
        $cleanedCount=0;
        $cleanedSize=0;
        
        // Get current list of files in the imagecache.
        $thumbnail_filelist = array_diff(
            scandir(storage_path() . "/imagecache"),
            ['..', '.']
        );
        foreach ($thumbnail_filelist as $thumbnail) {
            $fileNameParts = explode('-', $thumbnail);
            $checksum = $fileNameParts[0];
            $inUseMap[$checksum] = false;
        }
        
        // Using the checksum field, set each found file to true.
        foreach ($files as $file) {
            $inUseMap[$file->checksum]=true;
        }
        
        // Check each file to make sure it is needed. If not, clean it up.
        foreach ($thumbnail_filelist as $thumbnail) {
            $fileNameParts = explode('-', $thumbnail);
            $checksum = $fileNameParts[0];
            if (!$inUseMap[$checksum] || $force) {
                $filename = storage_path() . "/imagecache/" . $thumbnail;
                $fileStats = stat($filename);
                $cleanedSize += $fileStats["size"];
                $cleanedCount++;
                unlink(storage_path() . "/imagecache/" . $thumbnail);
            }
        }
        
        $this->info("Files cleaned: " . $cleanedCount);
        $this->info("Cleaned size: " . $cleanedSize . 'B');
    }
}
