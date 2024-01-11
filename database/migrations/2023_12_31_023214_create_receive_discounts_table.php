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
        Schema::create('receive_discounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_transaction_id'); // Add this line
            $table->foreign('stock_transaction_id')->references('id')->on('stock_transactions')->onDelete('cascade');
            $table->string('discount_type')->nullable();
            $table->decimal('amount', 15, 4)->nullable();
            $table->decimal('amount_dollar', 15, 4)->nullable();
            $table->decimal('change', 15, 4)->nullable();
            $table->decimal('change_dollar', 15, 4)->nullable();
            $table->decimal('received_amount', 15, 4)->nullable();
            $table->decimal('received_amount_dollar', 15, 4)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
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
        Schema::dropIfExists('receive_discounts');
    }
};
