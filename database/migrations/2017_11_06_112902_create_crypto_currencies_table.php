<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCryptoCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_currencies',function (Blueprint $table){

            $table->increments('id');
            $table->String('name');
            $table->String('alias');
            $table->String('image');
            $table->double('usd_value');
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
        Schema::drop('crypto_currencies');
    }
}
