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
        Schema::create('general_taxes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('rate');
            $table->string('method');
            $table->text('details')->nullable();
            $table->string('status')->default('active');
            // craeted_by , updated_by , deleted_by
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
        Schema::dropIfExists('general_taxes');
    }
};
