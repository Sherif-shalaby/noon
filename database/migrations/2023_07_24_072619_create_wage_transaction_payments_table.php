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
        Schema::create('wage_transaction_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id')->unsigned()->nullable();
            $table->foreign('transaction_id')->references('id')->on('wage_transactions')->onDelete('cascade');
            $table->decimal('amount', 15, 4);
            // $table->decimal('change_amount', 15, 4)->default(0);
            // $table->string('method');
            $table->string('paid_on');
            $table->boolean('is_return')->default(0);
            $table->unsignedBigInteger('payment_for')->nullable();
            // $table->string('ref_number')->nullable();
            // $table->string('card_number')->nullable();
            // $table->string('card_security')->nullable();
            // $table->string('card_month')->nullable();
            // $table->string('card_year')->nullable();
            // $table->string('cheque_number')->nullable();
            // $table->string('gift_card_number')->nullable();
            // $table->string('amount_to_be_used')->nullable()->comment('Gift card amount used for this payment');
            // $table->string('bank_deposit_date')->nullable();
            // $table->string('bank_name')->nullable();
            // $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('source_type')->nullable();
            $table->unsignedBigInteger('source_id')->nullable()->comment('Other users in the system as source.');
            // $table->text('payment_note')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('edited_by')->nullable()->constrained('users', 'id')->cascadeOnDelete();
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
        Schema::dropIfExists('wage_transaction_payments');
    }
};
