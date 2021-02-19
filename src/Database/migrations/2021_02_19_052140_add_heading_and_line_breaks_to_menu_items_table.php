<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHeadingAndLineBreaksToMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->integer('order_number')->unsigned()->nullable()->default(null)->after('parent_id');
            $table->string('heading')->nullable()->default(null)->after('name');
            $table->boolean('line_break_before')->default(false)->after('generate_permission');
            $table->boolean('line_break_after')->default(false)->after('line_break_before');
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
            $table->dropColumn(['order_number', 'heading', 'line_break_before', 'line_break_after']);
        });
    }
}
