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
        Schema::create('products_taxes', function (Blueprint $table) {
            $table->id();
            // ========= foreign key : product_id =========
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            // ========= foreign key : product_tax_id =========
            $table->unsignedBigInteger('product_tax_id')->nullable();
            $table->foreign('product_tax_id')->references('id')->on('product_taxes')->onDelete('cascade');

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
        Schema::dropIfExists('products_taxes');
    }
};
