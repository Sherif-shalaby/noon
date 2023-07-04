<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductDiscountsTable extends Migration {

	public function up()
	{
		Schema::create('product_discounts', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->integer('product_id')->unsigned();
			$table->string('discount_type')->nullable();
			$table->string('discount')->nullable();
			$table->string('discount_start_date')->nullable();
			$table->string('discount_end_date')->nullable();
			$table->text('discount_customer_types')->nullable();
			$table->text('discount_customers')->nullable();
			$table->text('discount_category')->nullable();
			$table->string('is_discount_permenant')->nullable();
			$table->integer('created_by');
			$table->integer('updated_by')->nullable();
			$table->integer('deleted_by')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('product_discounts');
	}
}