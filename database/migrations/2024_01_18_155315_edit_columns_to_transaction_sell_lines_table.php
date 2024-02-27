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

        // Drop foreign key constraints if they exist
        Schema::table('transaction_sell_lines', function (Blueprint $table) {
            $table->dropForeign('transaction_sell_lines_customer_id_foreign');
            $table->dropForeign('transaction_sell_lines_supplier_id_foreign');
        });

        // Modify the columns
        Schema::table('transaction_sell_lines', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->nullable()->change();
            $table->unsignedBigInteger('supplier_id')->nullable()->change();
        });

        // Recreate foreign key constraints
        Schema::table('transaction_sell_lines', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
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
            //
        });
    }
};
