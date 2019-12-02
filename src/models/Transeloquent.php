<?php
/**
 * Copyright (c) Muara Invoasi Bangsa 2019.
 *
 * Every code write on this page is belonging to MIB, don't copy or modify this page without permission from MIB.
 * more information please contact email below
 *
 *  frankyso.mail@gmail.com
 *  ijalnasution107@gmail.com
 *  wahyueko17@gmail.com
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transeloquent extends Model
{
    protected $fillable = ["value"];

    /**
     * Get the owning commentable model.
     */
    public function translatable()
    {
        return $this->morphTo();
    }
}
