<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\File;
use Illuminate\Support\Facades\Storage;

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
