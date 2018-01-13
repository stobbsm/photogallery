<?php
/**
 * Contains the PhotoGallery command.
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

/**
 * Contains the Photogallery command.
 * 
 * @category Class
 * @package  Photogallery
 * @author   Matthew Stobbs <matthew@sproutingcommunications.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @link     https://github.com/stobbsm/photogallery
 */
class PhotoGallery extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'photogallery';
    
    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Get the photo gallery storage path';
    
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
        $this->info('Gallery path: '. env('GALLERYPATH', 'not set'));
    }
}
