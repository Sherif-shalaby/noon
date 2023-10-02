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
        Schema::create('customer_offer_prices', function (Blueprint $table) {
            $table->id();
            // ++++++++++++++ foreign key : transaction_id ++++++++++++++
            $table->unsignedBigInteger('transaction_customer_offer_id');
            $table->foreign('transaction_customer_offer_id')->references('id')->on('transaction_customer_offer_prices')->onDelete('cascade');
            // ++++++++++++++ foreign key : product_id ++++++++++++++
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            // quantity
            $table->decimal('quantity', 15, 4);
            // dinar_sell_price
            $table->decimal('sell_price', 15, 4)->nullable();
            // dollar_sell_price
            $table->decimal('dollar_sell_price', 15, 4)->nullable();
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
        Schema::dropIfExists('customer_offer_prices');
    }
};
