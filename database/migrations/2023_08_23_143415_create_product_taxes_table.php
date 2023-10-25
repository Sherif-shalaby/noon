<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /* +++++++++++++++++++++ up() ++++++++++++++++++++++++++++ */
    public function up()
    {
        Schema::create('product_taxes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('rate');
            $table->text('details')->nullable();
            $table->string('status')->default('active');
            // created_by , updated_by , deleted_by
            $table->string('created_by')->nullable();
			$table->string('deleted_by')->nullable();
			$table->string('updated_by')->nullable();
            // created_at , updated_at
            $table->timestamps();
            // soft delete
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_taxes');
    }
};
