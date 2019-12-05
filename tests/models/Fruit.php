<?php


namespace Konnco\Transeloquent\Tests\models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Konnco\Transeloquent\Transeloquent;

class Fruit extends Eloquent
{
    use Transeloquent;
}