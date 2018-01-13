<?php
/**
 * Contains the FixFile artisan console command.
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
 * The FixFile artisan command.
 *
 * @category Class
 * @package  Photogallery
 * @author   Matthew Stobbs <matthew@sproutingcommunications.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @link     https://github.com/stobbsm/photogallery
 */
class FixFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'photogallery:fixfile {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix a broken file in the database';

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
        $this->line("Fixing file $id");
        $file = File::find($id);

        $checksum = hash_file('sha256', $file->getFullPath());
        $size = Storage::size($file->fullpath);
        $filetype = 'file';
        $mimetype = mime_content_type($file->getFullPath());

        $file->filetype = $filetype;
        $file->mimetype = $mimetype;
        $file->size = $size;
        $file->checksum = $checksum;

        try {
            $file->save();
            $this->info("Database updated successfully");
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
