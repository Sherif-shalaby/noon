<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /* +++++++++++++++++++++++++++++++ up() +++++++++++++++++++++++++++++++ */
    public function up()
    {
        Schema::create('transaction_customer_offer_prices', function (Blueprint $table) {
            $table->id();
            // +++++++++++++ foreign key : store_id +++++++++++++
            $table->unsignedInteger('store_id')->nullable();
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            // +++++++++++++ foreign key : customer_id +++++++++++++
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            // +++++++++++++ status +++++++++++++
            $table->enum('status', ['received', 'pending', 'ordered', 'final', 'draft', 'sent_admin']);
            $table->string('transaction_date');
            $table->boolean('is_quotation')->default(0);
            $table->boolean('block_qty')->default(0);
            $table->integer('block_for_days')->default(0);
            $table->integer('validity_days')->default(0);
            // +++++++++++++ tax_method +++++++++++++
            $table->string('tax_method', 25)->nullable();
            // +++++++++++++ discount +++++++++++++
            $table->string('discount_type')->nullable();
            $table->decimal('discount_value', 15, 4)->default(0)->comment('discount value applied by user');
            $table->decimal('sell_price', 15, 4)->nullable();
            $table->decimal('total_sell_price', 15, 4)->default(0.0000);
            $table->decimal('dollar_sell_price', 15, 4)->nullable();
            $table->decimal('total_dollar_sell_price', 15, 4)->default(0.0000);
            // +++++++++++++ foreign key : created_by +++++++++++++
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            // +++++++++++++ foreign key : updated_by +++++++++++++
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            // +++++++++++++ foreign key : deleted_by +++++++++++++
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_customer_offer_prices');
    }
};
