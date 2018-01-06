<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        printf("Gallery path: %s\n", env('GALLERYPATH', 'not set'));
    }
}
