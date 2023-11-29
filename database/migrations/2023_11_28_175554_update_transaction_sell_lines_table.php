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
        Schema::table('transaction_sell_lines', function (Blueprint $table) {
            // Update store_pos_id column
            // $table->unsignedBigInteger('store_pos_id')->after('employee_id')->nullable();
            $table->foreign('store_pos_id')->references('id')->on('store_pos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction_sell_lines', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['store_pos_id']);

            // Remove the store_pos_id column
            $table->dropColumn('store_pos_id');
        });
    }
};
