<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /* ++++++++++++++++++++++++ up() ++++++++++++++++++++++++ */
    public function up()
    {
        Schema::create('job_type_permission', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_type_id');
            $table->unsignedBigInteger('permission_id');
            // Define foreign keys
            $table->foreign('job_type_id')->references('id')->on('job_types')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');

            $table->timestamps();
        });
    }
    /* ++++++++++++++++++++++++ down() ++++++++++++++++++++++++ */
    public function down()
    {
        Schema::dropIfExists('job_type_permission');
    }
};
