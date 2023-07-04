<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCurrenciesTable extends Migration {

	public function up()
	{
		Schema::create('currencies', function(Blueprint $table) {
			$table->string('code')->nullable();
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('country');
			$table->string('currency');
			$table->string('symbol')->nullable();
			$table->string('thousand_seperator')->nullable()->default(',');
		});
	}

	public function down()
	{
		Schema::drop('currencies');
	}
}