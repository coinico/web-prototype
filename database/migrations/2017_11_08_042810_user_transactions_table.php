<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class User_transactions_tables.
 *
 * @author  The scaffold-interface created at 2017-11-08 04:28:10am
 * @link  https://github.com/amranidev/scaffold-interface
 */
class UserTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('user_wallet_transactions',function (Blueprint $table){

            $table->increments('id');

            $table->String('address_from');
            $table->String('address_to');
            $table->double('amount', 28, 18);
            $table->boolean('is_hold')->default(false);;
            $table->enum('type', array('credit', 'debit'));
            $table->String('memo');
            $table->String('transaction_hash');
            $table->double('transaction_fee', 28, 18);
            $table->double('total', 28, 18);

            /**
             * Foreignkeys section
             */
            $table->integer('user_wallet')->unsigned();
            $table->foreign('user_wallet')->references('id')->on('user_wallets');

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
        Schema::drop('user_wallet_transactions');
    }
}
