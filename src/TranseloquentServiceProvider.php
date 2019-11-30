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
//        $this->app->singleton('iPaymu', function () {
//            return new iPaymu(config('ipaymu.key'), [url(config('ipaymu.url_return')), url(config('ipaymu.url_notify')), url(config('ipaymu.url_cancel'))]);
//        });
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
        $this->publishes([__DIR__ . '/migrations' => database_path('migrations')], 'migrations');
    }

    public function publishModels()
    {
        $this->publishes([__DIR__ . '/models' => app_path()], 'model');
    }
}