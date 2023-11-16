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
        Schema::create('receipt_transaction_sell_lines_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_sell_line_id')->constrained('transaction_sell_lines', 'id')->cascadeOnDelete()
            ->name('rtslf_transaction_sell_lines_fk');
            $table->string('path');
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
        Schema::table('receipt_transaction_sell_lines_files', function (Blueprint $table) {
            //
        });
    }
};
