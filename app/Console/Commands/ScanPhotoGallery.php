<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Providers\FileBrowserServiceProvider;
use App\File;

class ScanPhotoGallery extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     *
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
        $fileDifference = false;
        printf(__('cmdline.scanning') . "\n");
        try {
            if (env('GALLERYPATH', false)) {
                $this->filebrowser = resolve('FileBrowser');
                $mediaFiles = $this->filebrowser->SearchMany('mimetype', config('filetypes'))->Flatten(false)->get();
                printf(__('cmdline.adding') . "\n");

                foreach ($mediaFiles as $file) {
                    $filehash = hash_file('sha256', $file['fullpath']);

                    try {
                        printf("Checking for existence of file in database: %s\n", $file['name']);
                        printf("Hash of file: %s\n", $filehash);
                        $oldfile = File::where('checksum', $filehash)->first();

                        if ($oldfile == null) {
                            throw new \Exception("File doesn't exist in the database.\n", E_NOTICE);
                        }

                        // Compare and update the database where needed.
                        if ($oldfile->filename != $file['name']) {
                            $fileDifference = true;
                            printf("Filename\t%s\t|| %s\n", $oldfile->filename, $file['name']);
                        }
                        if ($oldfile->fullpath != $file['fullpath']) {
                            $fileDifference = true;
                            printf("Fullpath\t%s\t|| %s\n", $oldfile->fullpath, $file['fullpath']);
                        }
                        if ($oldfile->filetype != $file['filetype']) {
                            $fileDifference = true;
                            printf("Filetype\t%s\t|| %s\n", $oldfile->filetype, $file['filetype']);
                        }
                        if ($oldfile->mimetype != $file['mimetype']) {
                            $fileDifference = true;
                            printf("Mimetype\t%s\t|| %s\n", $oldfile->mimetype, $file['mimetype']);
                        }
                        if ($oldfile->size != $file['size']) {
                            $fileDifference = true;
                            printf("Size\t%sB\t|| %sB\n", $oldfile->size, $file['size']);
                        }
                        if ($oldfile->checksum != $filehash) {
                            $fileDifference = true;
                            printf("Checksum\t%s\t|| %s\n", $oldfile->checksum, $filehash);
                        }

                        if ($fileDifference) {
                            $fileDifference=false;
                            if ($this->confirm("Update database (y/n)? ")) {
                                $oldfile->filename = $file['name'];
                                $oldfile->fullpath = $file['fullpath'];
                                $oldfile->filetype = $file['filetype'];
                                $oldfile->mimetype = $file['mimetype'];
                                $oldfile->size = $file['size'];
                                $oldfile->checksum = $filehash;
                                $oldfile->save();
                            } else {
                                printf("Skipping updates...\n");
                            }
                        }
                    } catch (\Exception $e) {
                        printf("Exception encountered: %s\n", $e->getMessage());

                        $newfile = File::firstOrNew([
                          'filename' => $file['name'],
                          'fullpath' => $file['fullpath'],
                          'filetype' => $file['filetype'],
                          'mimetype' => $file['mimetype'],
                          'size' => $file['size'],
                          'checksum' => $filehash
                        ]);
                        $newfile->save();
                    }
                }
            } else {
                throw new \Exception(__('cmdline.galleryerror'), E_NOTICE);
            }
        } catch (\Exception $e) {
            printf(__('cmdline.scanerror', [ "message" => $e->getMessage() ]));
            exit($e->getCode());
        }
    }
}
