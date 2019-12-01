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

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranseloquentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transeloquents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key');
            $table->text('value');
            $table->string('locale', 6);
            $table->nullableMorphs("transable");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transeloquents');
    }
}
