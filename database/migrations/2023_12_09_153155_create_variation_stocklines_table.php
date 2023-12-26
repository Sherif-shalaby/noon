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
        Schema::create('variation_stocklines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('variation_price_id')->nullable();
            $table->foreign('variation_price_id')->references('id')->on('variation_prices')
						->onDelete('cascade')
						->onUpdate('cascade');
            $table->unsignedBigInteger('stock_line_id')->nullable();
            $table->foreign('stock_line_id')->references('id')->on('add_stock_lines')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');
            $table->decimal('purchase_price', 15, 4)->nullable();
            $table->decimal('sell_price', 15, 4)->nullable();
            $table->decimal('dollar_purchase_price', 15, 4)->nullable();
            $table->decimal('dollar_sell_price', 15, 4)->default(0)->nullable();
            $table->decimal('sub_total', 15, 4)->nullable();
            $table->decimal('dollar_sub_total', 15, 4)->nullable();
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
        Schema::dropIfExists('variation_stocklines');
    }
};
