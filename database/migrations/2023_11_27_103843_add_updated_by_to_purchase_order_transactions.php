<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /* ++++++++++++++++++++ up() ++++++++++++++++++++ */
    public function up()
    {
        Schema::table('purchase_order_transactions', function (Blueprint $table) {
            // foreign key : updated_by
            $table->unsignedBigInteger('updated_by')->after('created_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }
    /* ++++++++++++++++++++ down() ++++++++++++++++++++ */
    public function down()
    {
        Schema::table('purchase_order_transactions', function (Blueprint $table) {
            $table->dropColumn('updated_by');
        });
    }
};
