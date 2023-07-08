<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobTypesTable extends Migration {

	public function up()
	{
		Schema::create('job_types', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('title');
			$table->date('date_of_creation')->nullable();
			$table->integer('created_by')->nullable();
			$table->integer('deleted_by')->nullable();
			$table->integer('updated_by')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('job_types');
	}
}