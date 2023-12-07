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
        Schema::create('variation_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('variation_id')->nullable();
            $table->foreign('variation_id')->references('id')->on('variations')
						->onDelete('cascade')
						->onUpdate('cascade');

            $table->integer('customer_type_id')->unsigned();

            $table->decimal('dinar_sell_price',10,3)->nullable()->default(0);
            $table->decimal('dinar_purchase_price',10,3)->nullable()->default(0);

            $table->decimal('percent',10,4)->nullable();
            $table->decimal('quantity',10,3)->nullable();
//            $table->decimal('quantity',10,3)->nullable();

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
        Schema::dropIfExists('variation_prices');
    }
};
