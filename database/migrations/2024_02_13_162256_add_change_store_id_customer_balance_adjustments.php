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
        Schema::table('customer_balance_adjustments', function (Blueprint $table) {
            $table->integer('store_id')->unsigned()->nullable()->change();
            $table->decimal('current_dollar_balance', 10,2)->nullable();
            $table->decimal('add_new_dollar_balance', 10,2)->nullable()->default('0');
            $table->decimal('new_dollar_balance', 10,2)->nullable()->default('0');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_balance_adjustments', function (Blueprint $table) {
            //
        });
    }
};
