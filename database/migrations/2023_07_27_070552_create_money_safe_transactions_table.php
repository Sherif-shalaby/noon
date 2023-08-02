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
        Schema::create('money_safe_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('money_safe_id')->nullable()->constrained('money_safes', 'id')->cascadeOnDelete();
            $table->string('source_type')->nullable();
            $table->foreignId('source_id')->nullable()->constrained('users', 'id')->cascadeOnDelete();
            $table->integer('store_id')->unsigned()->nullable();
            $table->foreign('store_id')->references('id')->on('stores');
            $table->integer('job_type_id')->unsigned()->nullable();
            $table->foreign('job_type_id')->references('id')->on('job_types');
            $table->decimal('amount', 15, 4);
            $table->decimal('balance', 15, 4)->default(0)->nullable();
            $table->string('type', 20);
            $table->foreignId('currency_id')->nullable()->constrained('currencies', 'id')->cascadeOnDelete();
            $table->text('details')->nullable();
			$table->foreignId('created_by')->nullable()->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('edited_by')->nullable()->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users', 'id')->cascadeOnDelete();
            $table->string('transaction_date');
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
        Schema::dropIfExists('money_safe_transactions');
    }
};
