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
        Schema::create('add_stock_lines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->foreign('transaction_id')->references('id')->on('stock_transactions')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained('products', 'id')->cascadeOnDelete();
            $table->decimal('quantity', 15, 4);
            $table->decimal('quantity_sold', 15, 4)->default(0)->comment('quantity sold from this purchase line');
            $table->decimal('quantity_returned', 15, 4)->default(0);
            $table->decimal('expired_qauntity', 15, 4)->default(0);
            $table->decimal('purchase_price', 15, 4);
            $table->decimal('final_cost', 15, 4)->default(0);
            $table->decimal('sub_total', 15, 4);
            $table->decimal('sell_price', 15, 4);
            $table->decimal('dollar_purchase_price', 15, 4);
            $table->decimal('dollar_final_cost', 15, 4)->default(0);
            $table->decimal('dollar_sub_total', 15, 4);
            $table->decimal('dollar_sell_price', 15, 4);
            $table->decimal('cost', 15, 4);
            $table->decimal('dollar_cost', 15, 4);
            $table->string('batch_number')->nullable();
            $table->string('manufacturing_date')->nullable();
            $table->string('expiry_date')->nullable();
            $table->integer('expiry_warning')->nullable();
            $table->integer('convert_status_expire')->nullable();
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
        Schema::dropIfExists('add_stock_lines');
    }
};
