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
        // ++++++++++++++++++++++++++++++++++ suppliers ++++++++++++++++++++++++++++++++++
        Schema::table('suppliers', function(Blueprint $table) {
            $table->string('name', 30)->nullable()->change();
            // ======== mobile_number of suppliers ========
            $table->json('mobile_number', 30)->nullable()->change();
            // ======== email of suppliers  ========
            $table->json('email', 30)->nullable()->change();
            // ======== owner_debt_in_dollar ===============
            $table->decimal('owner_debt_in_dollar', 15, 4)->after('notes')->nullable();
            // ======== owner_debt_in_dinar ===============
            $table->decimal('owner_debt_in_dinar', 15, 4)->after('notes')->nullable();
            // ======== state_id column ===============
            $table->unsignedBigInteger('state_id')->after('notes')->nullable();
            // ======== city_id column ===============
            $table->unsignedBigInteger('city_id')->after('notes')->nullable();
        });
        // ++++++++++++++++++++++++++++++++++ customers ++++++++++++++++++++++++++++++++++
        Schema::table('customers', function(Blueprint $table) {
            // ======== phone_number of customer mobile_number ========
            $table->json('phone')->nullable()->change();
            // ======== email of suppliers  ========
            $table->json('email', 30)->nullable()->change();
            // ======== min_amount_in_dollar ===============
            $table->decimal('min_amount_in_dollar', 15, 4)->after('notes')->nullable();
            // ======== max_amount_in_dollar ===============
            $table->decimal('max_amount_in_dollar', 15, 4)->after('notes')->nullable();
            // ======== min_amount_in_dinar ===============
            $table->decimal('min_amount_in_dinar', 15, 4)->after('notes')->nullable();
            // ======== max_amount_in_dinar ===============
            $table->decimal('max_amount_in_dinar', 15, 4)->after('notes')->nullable();
            // ======== balance_in_dollar ===============
            $table->decimal('balance_in_dollar', 15, 4)->after('notes')->nullable();
            // ======== balance_in_dinar ===============
            $table->decimal('balance_in_dinar', 15, 4)->after('notes')->nullable();
            // ======== state_id column ===============
            $table->unsignedBigInteger('state_id')->after('notes')->nullable();
            // ======== city_id column ===============
            $table->unsignedBigInteger('city_id')->after('notes')->nullable();
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
