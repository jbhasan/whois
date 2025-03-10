<?php

namespace Sayeed\Whois;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;

class WhoisServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
		//
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Register Whois as singleton
        $this->app->singleton('whois', function ($app) {
            return new Whois();
        });
    }
}
