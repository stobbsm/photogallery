<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\File;

class GenerateThumbnails extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'photogallery:generatethumbnails';
    
    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Generate Thumbnails for the application.';
    
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
        $this->line("Generating Thumbnails\n");
        $files = File::all();
        foreach ($files as $file) {
            try {
                $this->comment('Generating thumbnail for ' . $file->filename);
                $file->thumbnail();
            } catch (\Exception $e) {
                $this->error('Error generating thumbnail');
            }
        }
    }
}
    