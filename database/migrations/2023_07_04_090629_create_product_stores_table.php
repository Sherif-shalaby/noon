<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductStoresTable extends Migration {

	public function up()
	{
		Schema::create('product_stores', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('product_id')->unsigned();
			$table->integer('store_id')->unsigned();
			$table->double('quantity_available')->nullable();
			$table->double('quantity_expired')->nullable();
			$table->double('block_quantity')->nullable();
			$table->foreignId('created_by')->nullable()->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users', 'id')->cascadeOnDelete();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('product_stores');
	}
}