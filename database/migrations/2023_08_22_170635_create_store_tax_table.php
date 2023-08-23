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
        Schema::create('store_tax', function (Blueprint $table) {
            $table->id();
            // ========= foreign key : store_id =========
            $table->unsignedInteger('store_id')->nullable();
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            // ========= foreign key : general_taxe_id =========
            $table->unsignedInteger('general_tax_id')->nullable();
            $table->foreign('general_tax_id')->references('id')->on('general_taxes')->onDelete('cascade');
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
        Schema::dropIfExists('store_tax');
    }
};
