<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration {

	public function up()
	{
		Schema::create('categories', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name')->unique();
			$table->json('translations')->nullable();
			$table->text('description');
			$table->integer('parent_id')->unsigned()->nullable();
			$table->integer('class_id')->unsigned()->nullable();
			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('categories');
	}
}