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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users','id')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers','id')->nullOnDelete();
            $table->date('date');
            $table->double('price')->default(0)->nullable();
            $table->double('discount')->default(0)->nullable();
            $table->double('tax')->default(0)->nullable();
            $table->double('total')->default(0)->nullable();
            $table->string('payment_method')->default('cash');
            $table->string('status')->default('paid');
            $table->double('cash')->nullable();
            $table->double('card')->nullable();
            $table->double('rest')->default(0);
            $table->double('refund')->nullable();
            $table->enum('refund_status', ['creditor', 'debtor'])->nullable();
            $table->foreignId('last_update')->nullable()->constrained('users', 'id')->cascadeOnDelete();
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
        Schema::dropIfExists('invoices');
    }
};
