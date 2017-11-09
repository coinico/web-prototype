<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class UserWalletsTable.
 *
 * @author  The scaffold-interface created at 2017-11-06 10:20:35pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class UserWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('user_wallets',function (Blueprint $table){

            $table->increments('id');

            /**
             * Foreignkeys section
             */
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('crypto_currency')->unsigned(); // crypto currency que quiere vender
            $table->foreign('crypto_currency')->references('id')->on('crypto_currencies');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('user_wallets');
    }
}
