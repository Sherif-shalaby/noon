<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration {

	public function up()
	{
		Schema::create('stores', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('location')->nullable();
			$table->string('phone_number')->nullable();
			$table->string('email')->nullable();
			$table->string('manager_name')->nullable();
			$table->string('manager_mobile_number')->nullable();
			$table->text('details')->nullable();
			$table->integer('created_by')->nullable();
			$table->integer('deleted_by')->nullable();
			$table->integer('updated_by')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('stores');
	}
}