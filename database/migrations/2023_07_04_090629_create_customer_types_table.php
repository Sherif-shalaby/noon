<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerTypesTable extends Migration {

	public function up()
	{
		Schema::create('customer_types', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->text('translations')->nullable();
			$table->integer('store_id')->unsigned()->nullable();
			$table->foreignId('created_by')->nullable()->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('edited_by')->nullable()->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users', 'id')->cascadeOnDelete();
			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('customer_types');
	}
}