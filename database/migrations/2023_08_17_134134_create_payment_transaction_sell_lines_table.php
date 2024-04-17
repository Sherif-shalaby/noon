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
        Schema::create('payment_transaction_sell_lines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->foreign('transaction_id')->references('id')->on('transaction_sell_lines')->onDelete('cascade');
            $table->foreignId('received_currency')->nullable()->references('id')->on('currencies')->onDelete('cascade');
            $table->decimal('amount', 15, 4)->nullable();
            $table->decimal('dollar_amount', 15, 4)->nullable();
            $table->string('method');
            $table->string('paid_on');
            $table->boolean('is_return')->default(0);
            $table->unsignedBigInteger('payment_for')->nullable();
            $table->string('source_type')->nullable();
            $table->unsignedBigInteger('source_id')->nullable()->comment('Other users in the system as source.');
            $table->text('payment_note')->nullable();
            $table->decimal('exchange_rate');
            $table->unsignedBigInteger('created_by');
            $table->integer('is_confirmed')->default(0);
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
        Schema::dropIfExists('payment_transaction_sell_lines');
    }
};
