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
        Schema::table('cash_register_transactions', function (Blueprint $table) {
            $table->dropColumn('transaction_type');
            $table->dropColumn('transaction_id');
        });
        Schema::table('cash_register_transactions', function (Blueprint $table) {
            $table->decimal('dollar_amount', 15, 4)->nullable();
            $table->enum('transaction_type', ['initial', 'sell', 'transfer', 'refund', 'add_stock', 'cash_in', 'cash_out', 'expense',
                'returns', 'closing_cash', 'wages_and_compensation','pay_off'])->nullable();
            $table->foreignId('stock_transaction_id')->nullable()->constrained('stock_transactions', 'id')->cascadeOnDelete();
            $table->foreignId('sell_transaction_id')->nullable()->constrained('transaction_sell_lines', 'id')->cascadeOnDelete();
        });
        Schema::table('cash_registers', function (Blueprint $table) {
            $table->decimal('closing_dollar_amount', 15, 4)->nullable();
        });
        Schema::table('stock_transaction_payments', function (Blueprint $table) {
            $table->decimal('dollar_amount', 15, 4)->nullable();
        });
        Schema::table('money_safe_transactions', function (Blueprint $table) {
            $table->decimal('dollar_amount', 15, 4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
