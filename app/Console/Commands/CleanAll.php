<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\File;

class CleanAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'photogallery:cleanall';

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
        printf("Building filelist in the imagecache...\n");

        $inUseMap = array();
        $files = File::all();

        $cleanedCount=0;
        $cleanedSize=0;

        // Get current list of files in the imagecache.
        $thumbnail_filelist = array_diff(scandir(storage_path() . "/imagecache"), ['..', '.']);
        foreach ($thumbnail_filelist as $thumbnail) {
            $inUseMap[$thumbnail] = false;
        }

        // Using the checksum field, set each found file to true.
        foreach ($files as $file) {
            $inUseMap[$file->checksum]=true;
        }

        // Check each file to make sure it is needed. If not, clean it up.
        foreach ($thumbnail_filelist as $thumbnail) {
            if (!$inUseMap[$thumbnail]) {
                $filename = storage_path() . "/imagecache/" . $thumbnail;
                $fileStats = stat($filename);
                $cleanedSize += $fileStats["size"];
                $cleanedCount++;
                unlink(storage_path() . "/imagecache/" . $thumbnail);
            }
        }

        printf("Files cleaned: %b\n", $cleanedCount);
        printf("Cleaned size: %bB\n", $cleanedSize);
    }
}
