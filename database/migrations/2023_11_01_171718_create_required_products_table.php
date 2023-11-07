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
        Schema::create('required_products', function (Blueprint $table) {
            $table->id();
            // foreign key : employee_id
            $table->unsignedInteger('employee_id')->nullable();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            // foreign key : product_id
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            // foreign key : store_id
            $table->unsignedInteger('store_id')->nullable();
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            // foreign key : supplier_id
            $table->foreignId('supplier_id')->nullable()->references('id')->on('suppliers')->onDelete('cascade');
            // foreign key :branch_id
            $table->foreignId('branch_id')->nullable()->constrained('branches', 'id')->cascadeOnDelete();
            // status
            $table->enum('status', ['final',  'pending']);
            // order_date
            $table->date('order_date')->nullable();
            // dinar_purchase_price
            $table->decimal('purchase_price', 15, 4)->nullable();
            // dollar_purchase_price
            $table->decimal('dollar_purchase_price', 15, 4)->nullable();
            // required_quantity
            $table->unsignedInteger('required_quantity')->nullable();;
            // created_by
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            // updated_by
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            // deleted_by
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
        Schema::dropIfExists('required_products');
    }
};
