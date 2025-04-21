<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupRolePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_role', function (Blueprint $table) {
            $table->bigInteger('user_role_group_id')->unsigned()->index();
            $table->foreign('user_role_group_id')->references('id')->on('user_role_groups')->onDelete('cascade');
            $table->integer('user_role_id')->unsigned()->index();
            $table->foreign('user_role_id')->references('id')->on('user_roles')->onDelete('cascade');
            $table->primary(['user_role_group_id', 'user_role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('group_role');
    }
}
