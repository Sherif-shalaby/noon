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
        Schema::create('wage_transactions', function (Blueprint $table) {
            $table->increments('id');
         
			$table->integer('store_id')->unsigned()->nullable();
            $table->foreign('store_id')->references('id')->on('stores');
            $table->integer('employee_id')->unsigned()->nullable();
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->integer('wage_id')->unsigned()->nullable();
            $table->foreign('wage_id')->references('id')->on('wages');
            $table->string('type')->nullable();
            $table->decimal('grand_total', 15, 4)->nullable();
            $table->decimal('final_total', 15, 4)->default(0.0000);
            $table->enum('status', ['received', 'pending', 'ordered', 'final', 'draft', 'sent_admin', 'sent_supplier', 'partially_received', 'approved', 'rejected', 'expired', 'valid', 'declined', 'send_the_goods', 'compensated', 'canceled']);
            $table->string('transaction_date');
            $table->string('source_type')->nullable();
            $table->enum('payment_status', ['paid', 'pending', 'partial'])->nullable();
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
        Schema::dropIfExists('wage_transactions');
    }
};
