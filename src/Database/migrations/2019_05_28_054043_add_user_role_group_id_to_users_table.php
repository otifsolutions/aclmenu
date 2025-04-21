<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserRoleGroupIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {
            $table->bigInteger('user_role_group_id')->unsigned()->nullable()->after('team_id');
            $table->foreign('user_role_group_id')->references('id')->on('user_role_groups');
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
            $table->dropForeign(['user_role_group_id']);
            $table->dropColumn('user_role_group_id');
        });
    }
}
