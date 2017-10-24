<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\File;

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
        $file = File::find($id);
        $hash = hash_file('sha256', $file->fullpath);
        if ($file->checksum != $hash) {
            $file->checksum = $hash;
            $file->save();
        }
    }
}
