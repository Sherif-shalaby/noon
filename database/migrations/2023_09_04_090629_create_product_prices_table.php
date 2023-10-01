<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPricesTable extends Migration {

	public function up()
	{
		Schema::create('product_prices', function(Blueprint $table) {
			$table->id();
			// $table->unsignedBigInteger('product_id');
			// $table->unsignedBigInteger('product_id');
			$table->string('price_type')->nullable();
			$table->decimal('price',10,2)->nullable();
			$table->text('price_customer_types')->nullable();
			$table->text('price_customers')->nullable();
			$table->text('price_category')->nullable();
			$table->unsignedBigInteger('stock_transaction_id');
            $table->foreign('stock_transaction_id')->references('id')->on('stock_transactions')->onDelete('cascade');
			$table->integer('quantity');
			$table->integer('bonus_quantity');
			$table->integer('created_by');
			$table->integer('updated_by')->nullable();
			$table->integer('deleted_by')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('product_prices');
	}
}