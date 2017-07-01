<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use stobbsm\FileBrowser\FileBrowser;

class FileBrowserServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
      $this->app->bind('FileBrowser', function ($app) {
        return new FileBrowser(env('GALLERYPATH'));
      });
    }

    public function provides() {
      return [FileBrowser::class];
    }
}
