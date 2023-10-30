<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /* +++++++++++++++++++ up() +++++++++++++++++++ */
    public function up()
    {
        Schema::create('wage_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('file_name')->nullable();
            // ++++++++++++++ foreign key : wage_id ++++++++++++++
            $table->unsignedInteger('wage_id');
            $table->foreign('wage_id')->references('id')->on('wages')->onDelete('cascade');
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
        Schema::dropIfExists('wage_attachments');
    }
};
