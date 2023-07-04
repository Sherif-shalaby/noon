<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductStoresTable extends Migration {

	public function up()
	{
		Schema::create('product_stores', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('product_id')->unsigned();
			$table->integer('store_id')->unsigned();
			$table->double('quantity_available')->nullable();
			$table->double('quantity_expired')->nullable();
			$table->string('deleted_by')->nullable();
			$table->double('block_quantity')->nullable();
			$table->integer('created_by')->nullable();
			$table->integer('updated_by')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('product_stores');
	}
}