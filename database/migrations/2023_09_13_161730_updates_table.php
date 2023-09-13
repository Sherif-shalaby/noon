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
        Schema::table('suppliers', function(Blueprint $table) {
            $table->string('name', 30)->nullable()->change();
            $table->string('mobile_number', 30)->nullable(false)->change();
        });
        // +++++++++++++++++ phone_number of customer mobile_number
        Schema::table('customers', function(Blueprint $table) {
            $table->json('phone')->nullable()->change();
        });
        // +++++++++++++++++ mobile_number of suppliers mobile_number
        Schema::table('suppliers', function(Blueprint $table) {
            $table->json('mobile_number')->nullable()->change();
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
