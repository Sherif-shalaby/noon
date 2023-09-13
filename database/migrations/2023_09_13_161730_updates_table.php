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
            // ======== mobile_number of suppliers mobile_number ========
            $table->json('mobile_number', 30)->nullable()->change();
        });
        // +++++++++++++++++ customers +++++++++++++++++
        Schema::table('customers', function(Blueprint $table) {
            // ======== phone_number of customer mobile_number ========
            $table->json('phone')->nullable()->change();
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
