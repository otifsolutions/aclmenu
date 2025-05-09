<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDetailsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {
            $table->integer('user_role_id')->unsigned()->nullable()->after('id');
            $table->foreign('user_role_id')->references('id')->on('user_roles');
            $table->bigInteger('team_id')->unsigned()->nullable()->after('user_role_id');
            $table->foreign('team_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropForeign(['user_role_id']);
            $table->dropForeign(['team_id']);
            $table->dropColumn('user_role_id');
            $table->dropColumn('team_id');
        });
    }
}
