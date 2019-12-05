<?php

namespace Orchestra\Testbench\Tests;

use Konnco\Transeloquent\models\Transeloquent;
use Konnco\Transeloquent\TranseloquentServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--path' => realpath('tests/migrations'),
        ]);
        $this->withFactories(realpath('tests/factories'));
    }
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('transeloquent', ["locale"=>'en', 'model' => Transeloquent::class]);
    }
    protected function getPackageProviders($app)
    {
        return [
            TranseloquentServiceProvider::class,
        ];
    }
}