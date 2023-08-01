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
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('store_id')->nullable();
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
//            $table->unsignedBigInteger('supplier_id')->nullable();
//            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->enum('status', ['received',  'partially_received']);
            $table->enum('purchase_type', ['import', 'local']);
            $table->string('order_date')->nullable();
            $table->string('transaction_date');
            $table->enum('payment_status', ['paid', 'pending', 'partial'])->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('po_no')->nullable();
            $table->boolean('is_raw_material')->default(0);
            $table->unsignedBigInteger('purchase_order_id')->nullable();
            $table->decimal('other_expenses', 15, 4)->default(0);
            $table->decimal('other_payments', 15, 4)->default(0);
            $table->string('discount_type')->nullable();
            $table->decimal('discount_value', 15, 4)->default(0)->comment('discount value applied by user');
            $table->decimal('discount_amount', 15, 4)->default(0)->comment('amount calculated based on type and value');
            $table->decimal('grand_total', 15, 4)->nullable();
            $table->decimal('final_total', 15, 4)->default(0.0000);
            $table->text('details')->nullable();
            $table->text('notes')->nullable();
            $table->string('prova_datetime')->nullable();
            $table->string('source_type')->nullable();
            $table->foreignId('source_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->string('due_date')->nullable();
            $table->boolean('notify_me')->default(0);
            $table->integer('notify_before_days')->default(0);
            $table->unsignedBigInteger('canceled_by')->nullable();
            $table->foreign('canceled_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('stock_transactions');
    }
};
