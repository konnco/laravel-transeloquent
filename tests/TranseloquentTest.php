<?php


namespace konnco\Transeloquent\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Konnco\Transeloquent\Tests\models\Fruit;
use Orchestra\Testbench\Tests\TestCase;

class TranseloquentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testTranslate(): void
    {
        $fruit = factory(Fruit::class)->create(["name"=>"Banana"]);
        $fruit->setLocale("id");
        $fruit->name = "Pisang";
        $fruit->save();

        static::assertEquals("Pisang", $fruit->name);
    }
}