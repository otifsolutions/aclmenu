<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReadOnlyPermissionToMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            DB::statement("ALTER TABLE `menu_items` CHANGE `generate_permission` `generate_permission` ENUM('ALL','MANAGE_ONLY','READ_ONLY')");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            DB::statement("ALTER TABLE `menu_items` CHANGE `generate_permission` `generate_permission` ENUM('ALL','MANAGE_ONLY')");
        });
    }
}
