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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_category_id')->nullable();
            $table->string('name', 30);
            $table->string('company_name', 30)->nullable();
            $table->string('vat_number', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('mobile_number', 30)->nullable();
            $table->string('address', 60)->nullable();
            $table->string('city', 30)->nullable();
            $table->string('state', 30)->nullable();
            $table->string('country', 30)->nullable();
            $table->string('postal_code', 30)->nullable();
            $table->decimal('exchange_rate', 15, 4)->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
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
        Schema::dropIfExists('suppliers');
    }
};
