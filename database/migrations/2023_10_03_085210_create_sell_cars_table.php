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
        Schema::create('sell_cars', function (Blueprint $table) {
            $table->id();
            $table->string('driver_name')->nullable();
            $table->string('car_name')->nullable();
            $table->string('car_no')->nullable();

            $table->integer('representative_id')->unsigned()->nullable();
            $table->foreign('representative_id')->references('id')->on('employees')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('car_type')->nullable();
            $table->decimal('car_size', 15, 2)->nullable();
            $table->string('car_license')->nullable();
            $table->string('car_model')->nullable();
            $table->date('car_license_end_date')->nullable();
            $table->string('notify_by_end_car_license')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('edited_by')->nullable()->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users', 'id')->cascadeOnDelete();
            $table->softDeletes();
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
        Schema::dropIfExists('sell_cars');
    }
};
