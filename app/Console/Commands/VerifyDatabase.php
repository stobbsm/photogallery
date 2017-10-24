<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\File;

class VerifyDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'photogallery:verifydatabase';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifies the database integrity, and cleans it up if needed.';

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
        $files = File::all();
        foreach ($files as $file) {
            if (file_exists($file->fullpath)) {
                printf("Verfying file: %s\n", $file->fullpath);
                $hash = hash_file('sha256', $file->fullpath);
                if ($hash != $file->checksum) {
                    printf("Updating hash...\n");
                    $file->checksum = $hash;
                    $file->save();
                }
            }
        }
    }
}
