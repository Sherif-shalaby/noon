<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomersTable extends Migration {

	public function up()
	{
		Schema::create('customers', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('email')->nullable();
			$table->string('address')->nullable();
			$table->string('phone')->nullable();
			$table->decimal('deposit_balance', 10,2)->nullable();
			$table->decimal('added_balance', 10,2)->nullable();
			$table->softDeletes();
			$table->timestamps();
			$table->integer('created_by')->nullable();
			$table->integer('deleted_by')->nullable();
			$table->integer('updated_by')->nullable();
			$table->integer('customer_type_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('customers');
	}
}