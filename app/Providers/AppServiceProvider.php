<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        if (env('APP_URL')) {
            // Force the URL generator to use the full APP_URL including the subdirectory
            $this->app['url']->forceRootUrl(env('APP_URL'));
            
            // Since the deployment is HTTPS, ensure all generated links use https://
            $this->app['url']->forceScheme('https');
        }
    }
}
