<?php

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
        $this->loadMigrationsFrom(__DIR__.'/migrations/transeloquent_migrations.php');
//        $this->publishes([
//            __DIR__.'/migrations/transeloquent_migrations.php' => path,
//        ]);
    }
}