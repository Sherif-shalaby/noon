<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_stores', function (Blueprint $table) {
            // ++++++++++++++++ blocked_until column ++++++++++++++++
            $table->timestamp('blocked_until')->nullable()->after('block_quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_stores', function (Blueprint $table) {
            $table->dropColumn('blocked_until');
        });
    }
};
