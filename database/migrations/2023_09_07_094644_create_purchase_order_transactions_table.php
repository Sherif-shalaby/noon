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
        Schema::create('purchase_order_transactions', function (Blueprint $table) {
            $table->id();
            // foreign key : store_id
            $table->unsignedInteger('store_id')->nullable();
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            // foreign key : supplier_id
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            // foreign key : purchase_order_id
            $table->unsignedBigInteger('purchase_order_id')->nullable();
            $table->foreign('purchase_order_id')->references('id')->on('purchase_order_lines')->onDelete('cascade')->onUpdate('cascade');
            // sub_total
            $table->decimal('grand_total', 15, 4)->nullable();
            // final_total
            $table->decimal('final_total', 15, 4)->default(0.0000);
            // type column
            $table->string('type')->nullable();
            // status column
            $table->enum('status', ['received', 'pending', 'ordered', 'final', 'draft', 'sent_admin', 'sent_supplier', 'partially_received', 'approved', 'rejected', 'expired', 'valid', 'declined', 'send_the_goods', 'compensated', 'canceled']);
            // order_date column
            $table->string('order_date');
            // product_order_number column
            $table->string('po_no')->nullable();
            // transaction_date column
            $table->string('transaction_date');
            // payment_status column
            $table->enum('payment_status', ['paid', 'pending', 'partial'])->nullable();
            // details column
            $table->text('details')->nullable();
            // foreign key : created_by
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            // foreign key : deleted_by
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('cascade');

            // created_at , updated_at column
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
        Schema::dropIfExists('purchase_order_transactions');
    }
};
