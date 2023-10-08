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
        Schema::table('stock_transaction_payments', function (Blueprint $table) {
            $table->string('bank_deposit_date')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('ref_number')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_transaction_payments', function (Blueprint $table) {
            $table->string('bank_deposit_date')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('ref_number')->nullable();
        });
    }
};
