<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmployeesTable extends Migration {

	public function up()
	{
		Schema::create('employees', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('store_id')->unsigned()->nullable();
			$table->integer('updated_by')->nullable();
			$table->string('pass_string')->nullable();
			$table->string('employee_name');
			$table->date('date_of_start_working');
			$table->integer('job_type_id')->unsigned()->nullable();
			$table->string('mobile')->nullable();
			$table->date('date_of_birth')->nullable();
			$table->integer('annual_leave_per_year')->nullable();
			$table->integer('sick_leave_per_year')->nullable();
			$table->enum('payment_cycle', array('daily', 'weekly', 'monthly'))->nullable();
			$table->tinyInteger('commission')->nullable();
			$table->decimal('commission_value', 10,2)->nullable();
			$table->enum('commission_type', array('profit_sales'))->nullable();
			$table->enum('commision_calculation_period', array('daily', 'weekly', 'one_month', 'three_month'))->nullable();
			$table->integer('created_by')->nullable();
			$table->timestamps();
			$table->integer('deleted_by')->nullable();
			$table->softDeletes();
			$table->text('comissioned_products')->nullable();
			$table->text('comission_customer_types')->nullable();
			$table->text('comission_stores')->nullable();
			$table->text('comission_cashier')->nullable();
			$table->string('working_day_per_weak')->nullable();
			$table->string('check_in')->nullable();
			$table->string('check_out')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('employees');
	}
}