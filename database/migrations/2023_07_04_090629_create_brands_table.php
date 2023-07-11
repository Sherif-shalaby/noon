<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandsTable extends Migration {

	public function up()
	{
		Schema::create('brands', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('name')->unique();
			$table->integer('created_by')->nullable();
			$table->integer('edited_by')->nullable();
			$table->integer('deleted_by')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('brands');
	}
}