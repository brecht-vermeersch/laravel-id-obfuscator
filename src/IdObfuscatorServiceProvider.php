<?php declare(strict_types = 1);

namespace Lurza\IdObfuscator;

use Illuminate\Support\ServiceProvider;

class IdObfuscatorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('idObfuscator', function ($app) {
            return new IdObfuscatorManager($app);
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/idObfuscator.php' => config_path('idObfuscator.php'),
        ]);
    }
}