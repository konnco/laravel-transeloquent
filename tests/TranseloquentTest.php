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
        $fruit = factory(Fruit::class)->create(['name' => 'Banana']);
        $fruit->setLocale('id');
        $fruit->name = 'Pisang';
        $fruit->save();

        static::assertEquals('Pisang', $fruit->name);
    }

    /** @test */
    public function testChangeLocaleAfterGet(): void
    {
        $fruit = factory(Fruit::class)->create(['name' => 'Banana']);
        $fruit->setLocale('id');
        $fruit->name = 'Pisang';
        $fruit->save();

        $fruit = Fruit::first();
        $fruit->setLocale('id');

        static::assertEquals('Pisang', $fruit->name);
    }

    /** @test */
    public function testToArray(): void
    {
        $fruit = factory(Fruit::class)->create(['name' => 'Banana']);
        $fruit->setLocale('id');
        $fruit->name = 'Pisang';
        $fruit->save();

        static::assertEquals('Pisang', $fruit->toArray()['name']);
    }

    /** @test */
    public function testTranslateAvailable(): void
    {
        $fruit = factory(Fruit::class)->create(['name' => 'Banana']);
        $fruit->setLocale('id');
        $fruit->name = 'Pisang';
        $fruit->save();

        static::assertEquals(true, $fruit->translationExist('id'));
    }

    /** @test */
    public function testTranslateNotAvailable(): void
    {
        $fruit = factory(Fruit::class)->create(['name' => 'Banana']);
        $fruit->setLocale('id');
        $fruit->name = 'Pisang';
        $fruit->save();

        static::assertEquals(false, $fruit->translationExist('my'));
    }
}
