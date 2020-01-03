<?php

namespace BodeLocke\Rotessa;

use App;
use Illuminate\Support\ServiceProvider;

class RotessaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('rotessa', function () {
            return new Rotessa();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../config/rotessa.php' => config_path('rotessa.php')], 'config');
    }
}
