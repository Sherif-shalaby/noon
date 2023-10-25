<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // +++++++++++++++++++++++ up() +++++++++++++++++++++++
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('evening_shift_checkbox')->nullable();
            $table->string('evening_shift_check_in')->nullable();
            $table->string('evening_shift_check_out')->nullable();
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
