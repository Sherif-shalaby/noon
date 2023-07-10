<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration {

	public function up()
	{
		Schema::create('categories', function(Blueprint $table) {
			$table->id();
			$table->string('name')->unique();
            $table->string('cover')->nullable();
            $table->boolean('status')->default(false);
            $table->foreignId('parent_id')->nullable()->constrained('categories', 'id')->cascadeOnDelete();
            $table->longText('translation')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('last_update')->nullable()->constrained('users', 'id')->cascadeOnDelete();
			// $table->json('translations')->nullable();
			// $table->text('description');
			// $table->integer('parent_id')->unsigned()->nullable();
			// $table->integer('class_id')->unsigned()->nullable();
			// $table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('categories');
	}
}
