<?php
/**
 * Contains the ScanPhotoGallery command.
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
 * Contains the ScanPhotoGallery command.
 * 
 * @category Class
 * @package  Photogallery
 * @author   Matthew Stobbs <matthew@sproutingcommunications.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @link     https://github.com/stobbsm/photogallery
 */
class ScanPhotoGallery extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
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
        $startTime = microtime(true);
        $fileDifference = false;
        $this->line(__('cmdline.title_scan'));
        $pathPrefix = Storage::disk('gallery')
            ->getDriver()
            ->getAdapter()
            ->getPathPrefix();
        
        $this->info('Scanning: ' . $pathPrefix);
        try {
            $mimetypes = config('filetypes');
            if (env('GALLERYPATH', false)) {
                $this->filebrowser = resolve('FileBrowser');
                $mediaFiles = Storage::disk('gallery')->allFiles();
                $bar = $this->output->createProgressBar(count($mediaFiles));
                
                foreach ($mediaFiles as $file) {
                    $fullpath = $pathPrefix . $file;
                    $filehash = hash_file('sha256', $fullpath);
                    
                    try {
                        $oldfile = File::where('checksum', $filehash)->first();
                        
                        if ($oldfile == null) {
                            throw new \Exception(
                                __('cmdline.status_scan_filenotexist'),
                                E_NOTICE
                            );
                        }
                    } catch (\Exception $e) {
                        $mimetype = mime_content_type($fullpath);
                        if (in_array($mimetype, $mimetypes)) {
                            $filename = basename($fullpath);
                            $filetype = filetype($fullpath);
                            $filesize = Storage::disk('gallery')->size($file);
                            
                            $newfile = File::firstOrNew(
                                [
                                    'filename' => $filename,
                                    'fullpath' =>$file,
                                    'filetype' => $filetype,
                                    'mimetype' => $mimetype,
                                    'size' => $filesize,
                                    'checksum' => $filehash
                                ]
                            );
                            $newfile->save();
                        }
                    }
                    $bar->advance();
                }
            } else {
                throw new \Exception('GALLERYPATH not set', E_NOTICE);
            }
            $bar->finish();
            $this->line(" Done!");
        } catch (\Exception $e) {
            $this->error(__('cmdline.scanerror', [ "message" => $e->getMessage() ]));
            exit($e->getCode());
        }
        $endTime = microtime(true);
        $runTime = $endTime - $startTime;
        $this->info("Done in $runTime(s)");
    }
}
