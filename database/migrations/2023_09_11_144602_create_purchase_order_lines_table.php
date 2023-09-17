<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /* ++++++++++++++++++++++++ up() ++++++++++++++++++++++++ */
    public function up()
    {
        Schema::create('purchase_order_lines', function (Blueprint $table) {
            $table->id();
            // foreign key : product_id
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            // foreign key : purchase_transaction_id
            $table->unsignedBigInteger('purchase_order_transaction_id')->nullable();
            $table->foreign('purchase_order_transaction_id')->references('id')->on('purchase_order_transactions')
                                                            ->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('quantity', 15, 4);
            $table->decimal('purchase_price', 15, 4);
            $table->decimal('purchase_price_dollar', 15, 4);
            $table->decimal('sub_total', 15, 4);
            $table->timestamps();
        });
    }
    /* ++++++++++++++++++++++++ down() ++++++++++++++++++++++++ */
    public function down()
    {
        Schema::dropIfExists('purchase_order_lines');
    }
};
