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
        Schema::create('cash_register_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cash_register_id')->references('id')->on('cash_registers')->onDelete('cascade');
            $table->decimal('amount', 15, 4);
            $table->string('pay_method');
            $table->enum('type', ['debit', 'credit'])->nullable();
            $table->enum('transaction_type', ['initial', 'sell', 'transfer', 'refund', 'add_stock', 'cash_in', 'cash_out', 'expense', 'sell_return', 'closing_cash', 'wages_and_compensation'])->nullable();
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('transaction_payment_id')->nullable();
            $table->string('source_type', 25)->nullable();
            $table->foreignId('source_id')->nullable()->comment('Other users in the system as source.')
                ->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('referenced_id')->nullable()->comment('used for cash in and cash out.');
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_register_transactions');
    }
};
