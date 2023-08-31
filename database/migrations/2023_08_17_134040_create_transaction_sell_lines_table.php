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
        Schema::create('transaction_sell_lines', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('store_id')->nullable();
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->unsignedBigInteger('transaction_currency');
            $table->foreign('transaction_currency')->references('id')->on('currencies')->onDelete('cascade');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('store_pos_id')->nullable();
            $table->string('type')->nullable();
            $table->enum('status', ['received', 'pending', 'ordered', 'final', 'draft', 'sent_admin', 'sent_supplier', 'partially_received', 'approved', 'rejected', 'expired', 'valid', 'declined', 'send_the_goods', 'compensated', 'canceled']);
            $table->string('transaction_date');
            $table->enum('payment_status', ['paid', 'pending', 'partial'])->nullable();
            $table->string('invoice_no')->nullable();
            $table->boolean('is_direct_sale')->default(0);
            $table->boolean('is_return')->default(0);
            $table->boolean('is_quotation')->default(0);
            $table->boolean('is_internal_stock_transfer')->default(0);
            $table->boolean('block_qty')->default(0);
            $table->integer('block_for_days')->default(0);
            $table->integer('validity_days')->default(0);
            $table->unsignedBigInteger('parent_sale_id')->nullable();
            $table->unsignedBigInteger('return_parent_id')->nullable();
            $table->unsignedBigInteger('purchase_order_id')->nullable();
            $table->unsignedBigInteger('add_stock_id')->nullable();
            $table->string('tax_method', 25)->nullable();
            $table->decimal('total_tax', 15, 4)->nullable();
            $table->decimal('total_item_tax', 15, 4)->default(0);
            $table->decimal('other_expenses', 15, 4)->default(0);
            $table->decimal('other_payments', 15, 4)->default(0);
            $table->string('discount_type')->nullable();
            $table->decimal('discount_value', 15, 4)->default(0)->comment('discount value applied by user');
            $table->decimal('discount_amount', 15, 4)->default(0)->comment('amount calculated based on type and value');
            $table->decimal('total_sp_discount', 15, 4)->default(0)->comment('total of sale promotion discount');
            $table->decimal('total_product_surplus', 15, 4)->default(0)->comment('total of product surplus');
            $table->decimal('total_product_discount', 15, 4)->default(0)->comment('total of product discount');
            $table->string('ref_no')->nullable();
            $table->decimal('grand_total', 15, 4)->nullable();
            $table->decimal('final_total', 15, 4)->default(0.0000);
            $table->decimal('exchange_rate', 15, 4)->default(1);
            $table->integer('rp_earned')->default(0);
            $table->integer('rp_redeemed')->default(0);
            $table->integer('rp_redeemed_value')->default(0);
            $table->decimal('current_deposit_balance', 15, 4)->default(0);
            $table->decimal('used_deposit_balance', 15, 4)->default(0);
            $table->decimal('remaining_deposit_balance', 15, 4)->default(0);
            $table->decimal('add_to_deposit', 15, 4)->default(0);
            $table->text('details')->nullable();
            $table->text('reason')->nullable();
            $table->text('sale_note')->nullable();
            $table->text('staff_note')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('terms_and_condition_id')->nullable();
            $table->unsignedBigInteger('canceled_by')->nullable();
            $table->foreign('canceled_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('transaction_sell_lines');
    }
};
