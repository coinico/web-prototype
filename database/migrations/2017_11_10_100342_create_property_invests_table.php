<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyInvestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_invests', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('property_id')->unsigned();
            $table->foreign('property_id')->references('id')->on('properties');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');


            $table->integer('transaction_id')->unsigned();

            $table->decimal('value',15,2);

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
        Schema::dropIfExists('property_invests');
    }
}
