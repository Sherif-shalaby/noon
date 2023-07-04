<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerTypesTable extends Migration {

	public function up()
	{
		Schema::create('customer_types', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->integer('deleted_by')->nullable();
			$table->integer('created_by')->nullable();
			$table->integer('updated_by')->nullable();
			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('customer_types');
	}
}