<?php

namespace konnco\Transeloquent;

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
        $this->publishModels();
    }

    public function publishMigrations()
    {
        $this->publishes([__DIR__.'/migrations' => database_path('migrations')], 'transeloquent');
    }

    public function publishModels()
    {
        $this->publishes([__DIR__.'/models' => app_path()], 'transeloquent');
    }
}
