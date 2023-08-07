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
        Schema::create('cash_registers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('store_id');
            $table->foreign('store_id')->nullable()->references('id')->on('stores')->onDelete('cascade');
            $table->foreignId('store_pos_id')->nullable()->references('id')->on('store_pos')->onDelete('cascade');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('status', ['open', 'close']);
            $table->dateTime('closed_at')->nullable();
            $table->decimal('closing_amount', '15', 4)->default(0);
            $table->decimal('discrepancy', '15', 4)->default(0);
            $table->string('source_type', 25)->nullable();
            $table->unsignedBigInteger('cash_given_to')->nullable();
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('cash_registers');
    }
};
