<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration {

	public function up()
	{
		Schema::create('currencies', function(Blueprint $table) {
			$table->increments('id');
			$table->string('code')->nullable();
			$table->string('country');
			$table->string('currency');
			$table->string('symbol')->nullable();
			$table->string('thousand_seperator')->nullable()->default(',');
			$table->string('decimal_seperator')->nullable()->default('.');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('currencies');
	}
}