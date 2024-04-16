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
        Schema::table('sell_lines', function (Blueprint $table) {
            $table->double('quantity')->change(); 
        });
        Schema::table('add_stock_lines', function (Blueprint $table) {
            $table->double('quantity')->change(); 
            $table->double('quantity_sold')->change(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sell_lines', function (Blueprint $table) {
            //
        });
    }
};
