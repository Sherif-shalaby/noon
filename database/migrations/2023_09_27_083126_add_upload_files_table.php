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
        Schema::table('stock_transactions', function (Blueprint $table) {
            $table->text('file')->nullable();
        });
        Schema::table('stock_transaction_payments', function (Blueprint $table) {
            $table->text('upload_documents')->nullable();
        });
        Schema::table('employees', function (Blueprint $table) {
            $table->text('image')->nullable();
            $table->text('upload_documents')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
