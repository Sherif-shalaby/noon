<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration {

	public function up()
	{
		Schema::create('customers', function(Blueprint $table) {
            $table->id();
			$table->string('name');
			$table->string('email')->nullable();
			$table->string('address')->nullable();
			$table->string('phone')->nullable();
            $table->decimal('balance',10,2)->default(0);
            $table->decimal('dollar_balance',10,2)->default(0);
			$table->decimal('deposit_balance', 10,2)->nullable()->default(0);
			$table->decimal('added_balance', 10,2)->nullable()->default(0);
			$table->integer('customer_type_id')->unsigned();
			$table->foreignId('created_by')->nullable()->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users', 'id')->cascadeOnDelete();
			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('customers');
	}
}
