<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned()->nullable();
            $table->string('payment_type');
            $table->decimal('other_payment')->default(0);
            $table->string('account_period')->nullable();
            $table->date('acount_period_start_date')->nullable();
            $table->date('acount_period_end_date')->nullable();
            $table->decimal('deductibles')->nullable()->default(0);
            $table->text('reasons_of_deductibles')->nullable();
            $table->decimal('amount');
            $table->decimal('net_amount');
            $table->date('payment_date');
            $table->text('notes')->nullable();
            $table->date('date_of_creation');
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->string('source_type')->nullable();
			$table->foreignId('source_id')->nullable()->constrained('users', 'id')->cascadeOnDelete();
			$table->foreignId('created_by')->nullable()->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('edited_by')->nullable()->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users', 'id')->cascadeOnDelete();
			$table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wages');
    }
};
