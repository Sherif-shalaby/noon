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
        Schema::create('transfer_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sender_store_id')->nullable();
            $table->foreign('sender_store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->unsignedInteger('receiver_store_id')->nullable();
            $table->foreign('receiver_store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->string('type')->nullable();
            $table->string('transaction_date');
            $table->decimal('final_total', 15, 4)->default(0.0000);
            $table->decimal('dollar_final_total', 15, 4)->default(0.0000);
            $table->string('invoice_no')->nullable();
            $table->text('notes')->nullable();
            $table->text('details')->nullable();
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
        Schema::dropIfExists('transfer_transactions');
    }
};
