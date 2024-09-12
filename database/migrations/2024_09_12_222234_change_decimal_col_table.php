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
        Schema::table('product_prices', function (Blueprint $table) {
            $table->decimal('dinar_price_customers', 15, 2)->change();
        });

        Schema::table('variation_prices', function (Blueprint $table) {
            $table->decimal('dinar_sell_price', 15, 2)->change();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_prices', function (Blueprint $table) {
            $table->decimal('dinar_price_customers', 10, 2)->change();
        });
        Schema::table('variation_prices', function (Blueprint $table) {
            $table->decimal('dinar_sell_price', 10, 2)->change();
        });
    }
};
