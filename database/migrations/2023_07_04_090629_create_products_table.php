<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration {

	public function up()
	{
		Schema::create('products', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->text('translations')->nullable();
			$table->string('sku')->nullable();
			$table->integer('category_id')->unsigned()->nullable();
			// $table->text('subcategory_id')->nullable();
			$table->text('image')->nullable();
			// $table->integer('store_id')->unsigned()->nullable();
			$table->string('details')->nullable();
			$table->text('details_translations')->nullable();
			$table->decimal('height', 10,2)->nullable();
			$table->decimal('length', 10,2)->nullable();
			$table->decimal('width', 10,2)->nullable();
			$table->decimal('size', 10,2)->nullable()->default(0);
			$table->decimal('weight', 10,2)->nullable();
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