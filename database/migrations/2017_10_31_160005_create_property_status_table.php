<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('status_type');
            $table->timestamps();
        });

        DB::table('property_status')->insert([
            [
                'name' => 'open',
                'status_type' => '1'
            ],
            [
                'name' => 'waiting',
                'status_type' => '2'
            ],
            [
                'name' => 'denied',
                'status_type' => '3'
            ],
            [
                'name' => 'accepted',
                'status_type' => '4'
            ],
            [
                'name' => 'verification_process',
                'status_type' => '5'
            ],
            [
                'name' => 'verified',
                'status_type' => '6'
            ],
            [
                'name' => 'no_agreement',
                'status_type' => '7'
            ],
            [
                'name' => 'no_verified',
                'status_type' => '8'
            ],
            [
                'name' => 'published_and_tokenized',
                'status_type' => '9'
            ],
            [
                'name' => 'failure',
                'status_type' => '10'
            ],
            [
                'name' => 'in_market',
                'status_type' => '11'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_status');
    }
}
