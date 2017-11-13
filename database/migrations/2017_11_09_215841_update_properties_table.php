<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('properties', function ($table) {
            $table->longText('description');
            $table->string('detail');
            $table->string('images');
            $table->decimal('value',15,2);
            $table->string('city');
            $table->string('location');
            $table->string('bidding_time');
            $table->string('features');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('properties', function ($table) {
            $table->dropColumn('description');
            $table->dropColumn('detail');
            $table->dropColumn('images');
            $table->dropColumn('value');
            $table->dropColumn('city');
            $table->dropColumn('location');
            $table->dropColumn('bidding_time');
            $table->dropColumn('features');
        });
    }
}
