<?php

namespace Konnco\Transeloquent;

use Illuminate\Support\ServiceProvider;

class TranseloquentServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishMigrations();
//        $this->publishModels();
        $this->publishConfig();
    }

    public function publishMigrations()
    {
        $this->publishes([__DIR__.'/migrations' => database_path('migrations')], 'transeloquent');
    }

    public function publishModels()
    {
        $this->publishes([__DIR__.'/models' => app_path()], 'transeloquent');
    }

    public function publishConfig()
    {
        $this->publishes([__DIR__.'/config/transeloquent.php' => config_path('transeloquent.php')], 'transeloquent');
        $this->mergeConfigFrom(__DIR__.'/config/transeloquent.php', 'transeloquent');
    }
}
