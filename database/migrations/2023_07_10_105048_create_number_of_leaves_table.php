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
        Schema::create('number_of_leaves', function (Blueprint $table) {
            $table->id();
            $table->Integer('employee_id')->unsigned();
            $table->unsignedBigInteger('leave_type_id');
            $table->integer('number_of_days')->default(0)->nullable();
            $table->boolean('enabled')->default(0);
            $table->unsignedBigInteger('created_by');
            $table->BigInteger('updated_by')->nullable()->unsigned();
            $table->BigInteger('deleted_by')->nullable()->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('leave_type_id')->references('id')->on('leave_types')
                ->onDelete('restrict')
                ->onUpdate('restrict');
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
        Schema::dropIfExists('number_of_leaves');
    }
};
