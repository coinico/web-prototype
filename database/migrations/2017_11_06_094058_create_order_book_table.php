<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_book', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('user_id')->unsigned(); // usuario que la creo
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('crypto_currency_from')->unsigned(); // crypto currency que quiere vender
            $table->foreign('crypto_currency_from')->references('id')->on('crypto_currencies');

            $table->integer('crypto_currency_to')->unsigned();  /// crypto currency que quiere recibir
            $table->foreign('crypto_currency_to')->references('id')->on('crypto_currencies');

            $table->string('type');  // ask o bid
            $table->integer('quantity'); // cantidad
            $table->string('value'); // valor que se quiere recibir

            $table->timestamp('creation_date')->nullable();

            $table->string('execution_type');  // cuando fue ejecutada si es un buy o un sell
            $table->boolean('executed')->default(false); // si fue ejecutada

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
        Schema::dropIfExists('order_book');
    }
}
