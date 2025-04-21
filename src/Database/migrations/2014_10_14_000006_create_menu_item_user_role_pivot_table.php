<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemUserRolePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_item_user_role', function (Blueprint $table) {
            $table->integer('menu_item_id')->unsigned()->index();
            $table->foreign('menu_item_id')->references('id')->on('menu_items')->onDelete('cascade');
            $table->integer('user_role_id')->unsigned()->index();
            $table->foreign('user_role_id')->references('id')->on('user_roles')->onDelete('cascade');
            $table->primary(['menu_item_id', 'user_role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('menu_item_user_role');
    }
}
