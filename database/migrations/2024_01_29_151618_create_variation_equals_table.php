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
        Schema::create('variation_equals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('variation_id')->nullable();
            $table->foreign('variation_id')->references('id')->on('variations')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('equal',15,4)->nullable();
            $table->unsignedBigInteger('stockline_id')->nullable();
            $table->foreign('stockline_id')->references('id')->on('add_stock_lines')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('variation_equals');
    }
};
