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
        Schema::table('wages', function (Blueprint $table) {
            // Rename the column
            $table->renameColumn('account_period', 'payment_cycle');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wages', function (Blueprint $table) {
            // Reverse the column name back to 'account_period' if necessary
            $table->renameColumn('payment_cycle', 'account_period');
        });
    }
};
