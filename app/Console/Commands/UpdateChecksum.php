<?php
/**
 * Contains the UpdateChecksum command.
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
use Illuminate\Support\Facades\Storage;
/**
 * Contains the UpdateChecksum command
 * 
 * @category Class
 * @package  Photogallery
 * @author   Matthew Stobbs <matthew@sproutingcommunications.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @link     https://github.com/stobbsm/photogallery
 */
class UpdateChecksum extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'photogallery:updatechecksum {id}';
    
    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Update the sha256 checksum for a given file id';
    
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
        $id = intval($this->argument('id'));
        $this->line("Updating checksum for $id");
        $file = File::find($id);
        $hash = hash_file('sha256', $file->getFullPath());
        if ($file->checksum != $hash) {
            $file->checksum = $hash;
            $file->save();
        }
    }
}
