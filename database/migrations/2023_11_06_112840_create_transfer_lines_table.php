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
        Schema::create('transfer_lines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->foreign('transaction_id')->references('id')->on('transfer_transactions')->onDelete('cascade');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('variation_id');
            $table->decimal('quantity', 15, 4);
            $table->decimal('purchase_price', 15, 4);
            $table->decimal('dollar_purchase_price', 15, 4);
            $table->decimal('sell_price', 15, 4);
            $table->decimal('dollar_sell_price', 15, 4);
            $table->decimal('exchange_rate');
            $table->decimal('sub_total', 15, 4);
            $table->decimal('dollar_sub_total', 15, 4);
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('edited_by')->nullable()->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users', 'id')->cascadeOnDelete();
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
        Schema::dropIfExists('transfer_lines');
    }
};
