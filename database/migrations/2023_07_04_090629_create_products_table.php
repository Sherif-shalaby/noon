<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	public function up()
	{
		Schema::create('products', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->json('translations')->nullable();
			$table->integer('class_id')->unsigned();
			$table->string('sku')->nullable();
			$table->integer('category_id')->unsigned()->nullable();
			$table->integer('subcategory_id')->unsigned()->nullable();
			$table->string('details')->nullable();
			$table->decimal('height', 10,2)->nullable();
			$table->decimal('weight', 10,2)->nullable();
			$table->decimal('length', 10,2)->nullable();
			$table->decimal('width', 10,2)->nullable();
			$table->boolean('active')->default(1);
			$table->integer('created_by')->nullable();
			$table->integer('edited_by')->nullable();
			$table->integer('deleted_by')->nullable();
			$table->softDeletes();
			$table->integer('brand_id')->unsigned()->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('products');
	}
}