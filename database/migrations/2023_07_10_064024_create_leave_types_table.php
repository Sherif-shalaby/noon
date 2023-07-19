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
        Schema::create('leave_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('number_of_days_per_year')->nullable();
            $table->date('date_of_creation');
            $table->unsignedBigInteger('created_by');
            $table->BigInteger('updated_by')->nullable()->unsigned();
            $table->BigInteger('deleted_by')->nullable()->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('deleted_by')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('updated_by')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_types');
    }
};
