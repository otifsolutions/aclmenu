<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MenuItemsTableGetsShowOnSidebar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_items', function($table) {
            $table->boolean('show_on_sidebar')->after('parent_id')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu_items', function($table) {
            $table->dropColumn('show_on_sidebar');
        });
    }
}
