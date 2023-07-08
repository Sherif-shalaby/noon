<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesTable extends Migration {

	public function up()
	{
		Schema::create('classes', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name')->unique();
			$table->json('translations')->nullable();
			$table->text('description')->nullable();
			$table->boolean('status')->default(1);
			$table->integer('created_by')->nullable();
			$table->integer('updated_by')->unsigned()->nullable();
			$table->integer('deleted_by')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('classes');
	}
}