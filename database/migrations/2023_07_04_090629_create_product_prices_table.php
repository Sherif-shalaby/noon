<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPricesTable extends Migration {

	public function up()
	{
		Schema::create('product_prices', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('product_id')->unsigned();
			// $table->string('price_type')->nullable();
			$table->decimal('price',10,2)->nullable();
			$table->string('price_start_date')->nullable();
			$table->string('price_end_date')->nullable();
			$table->text('price_customer_types')->nullable();
			$table->text('price_customers')->nullable();
			$table->text('price_category')->nullable();
			$table->string('is_price_permenant')->nullable();
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