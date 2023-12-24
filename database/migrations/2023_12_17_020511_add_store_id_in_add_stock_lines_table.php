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
        Schema::table('add_stock_lines', function (Blueprint $table) {
            $table->unsignedInteger('store_id')->nullable();
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->decimal('discount_percent', 15, 4)->nullable();
            $table->decimal('discount', 15, 4)->nullable();
            $table->decimal('cash_discount', 15, 4)->nullable();
            $table->decimal('seasonal_discount', 15, 4)->nullable();
            $table->decimal('annual_discount', 15, 4)->nullable();
            $table->foreignId('used_currency')->nullable()->references('id')->on('currencies')->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->boolean('discount_on_bonus_quantity')->default(0)->nullable();
            $table->boolean('discount_dependency')->default(0)->nullable();
            $table->decimal('bonus_quantity', 15, 4)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('add_stock_lines', function (Blueprint $table) {
            //
        });
    }
};
