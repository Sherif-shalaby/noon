<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerBalanceAdjustmentsTable extends Migration {

	public function up()
	{
		Schema::create('customer_balance_adjustments', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('customer_id')->unsigned();
			$table->integer('store_id')->unsigned();
			$table->decimal('current_balance', 10,2)->nullable();
			$table->decimal('add_new_balance', 10,2)->nullable()->default('0');
			$table->decimal('new_balance', 10,2)->nullable()->default('0');
			$table->text('notes')->nullable();
			$table->datetime('date_and_time')->nullable();
			$table->integer('created_by')->nullable();
			$table->integer('deleted_by')->nullable();
			$table->integer('updated_by')->nullable();
			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('customer_balance_adjustments');
	}
}