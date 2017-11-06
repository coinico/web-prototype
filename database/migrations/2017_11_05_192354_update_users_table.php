<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('role');
        });
        Schema::table('users', function ($table) {
            $table->enum('role', array('user', 'community','owner','investor','referee','agency', 'admin'));
        });

        DB::table('users')
            ->where('id', 1)
            ->update(['role' => 'admin']);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('role');
        });
        Schema::table('users', function ($table) {
            $table->enum('role', array('user', 'redac', 'admin'));
        });
    }
}
