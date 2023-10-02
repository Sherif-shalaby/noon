<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPricesTable extends Migration {

	public function up()
	{
		Schema::create('product_prices', function(Blueprint $table) {
			$table->id();
			$table->string('price_type')->nullable();
			$table->decimal('price',10,2)->nullable();
			$table->text('price_customer_types')->nullable();
			$table->text('price_customers')->nullable();
			$table->text('price_category')->nullable();
			$table->unsignedBigInteger('stock_line_id')->nullable();
            $table->foreign('stock_line_id')->references('id')->on('add_stock_lines')->onDelete('cascade');
			$table->integer('quantity')->nullable();
			$table->integer('bonus_quantity')->nullable();
			$table->integer('created_by')->nullable();
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