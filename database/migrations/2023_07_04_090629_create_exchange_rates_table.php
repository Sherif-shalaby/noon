<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchangeRatesTable extends Migration {

	public function up()
	{
		Schema::create('exchange_rates', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->integer('store_id')->unsigned()->nullable();
			$table->integer('received_currency_id')->unsigned()->nullable();
			$table->decimal('conversion_rate', 10,2)->nullable();
			$table->integer('default_currency_id')->unsigned()->nullable();
			$table->date('expiery_date')->nullable();
			$table->integer('created_by')->nullable();
			$table->integer('updated_by')->nullable();
			$table->integer('deleted_by')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('exchange_rates');
	}
}
