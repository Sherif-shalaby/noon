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
        Schema::create('stock_return_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_transaction_id')->nullable()->references('id')->on('stock_transactions')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->references('id')->on('products')->onDelete('cascade');
            $table->foreignId('variation_id')->nullable()->references('id')->on('variations')->onDelete('cascade');
            // $table->unsignedBigInteger('product_id');
            // $table->unsignedBigInteger('variation_id');
            $table->decimal('quantity', 15, 4);
            $table->decimal('sell_price', 15, 4);
            $table->decimal('sub_total', 15, 4);
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
        Schema::dropIfExists('stock_return_lines');
    }
};
