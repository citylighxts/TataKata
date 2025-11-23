<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot()
    {
        if (env('APP_URL')) {
            $this->app['url']->forceRootUrl(env('APP_URL'));
            
            $this->app['url']->forceScheme('http');
        }
    }
}
