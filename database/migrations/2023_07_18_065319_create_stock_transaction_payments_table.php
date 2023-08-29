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
        Schema::create('stock_transaction_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_transaction_id');
            $table->foreign('stock_transaction_id')->references('id')->on('stock_transactions')->onDelete('cascade');
            $table->foreignId('paying_currency')->nullable()->references('id')->on('currencies')->onDelete('cascade');
            $table->decimal('amount', 15, 4);
            $table->string('method');
            $table->string('paid_on');
            $table->boolean('is_return')->default(0);
            $table->unsignedBigInteger('payment_for')->nullable();
            $table->string('source_type')->nullable();
            $table->unsignedBigInteger('source_id')->nullable()->comment('Other users in the system as source.');
            $table->text('payment_note')->nullable();
            $table->decimal('exchange_rate');
            $table->unsignedBigInteger('created_by');
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
        Schema::dropIfExists('stock_transaction_payments');
    }
};
