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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
			$table->string('name');
			$table->text('translations')->nullable();
			$table->string('sku')->nullable();
			$table->unsignedBigInteger('category_id')->nullable();
			$table->unsignedBigInteger('subcategory_id1')->nullable();
			$table->unsignedBigInteger('subcategory_id2')->nullable();
			$table->unsignedBigInteger('subcategory_id3')->nullable();
			$table->text('image')->nullable();
			// $table->unsignedBigInteger('unit_id')->nullable();
			$table->string('details')->nullable();
			$table->text('details_translations')->nullable();
			$table->boolean('active')->default(1);
			$table->integer('brand_id')->unsigned()->nullable();
			$table->foreignId('created_by')->nullable()->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('edited_by')->nullable()->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users', 'id')->cascadeOnDelete();
            // method column
            $table->string('method')->nullable();
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
        Schema::dropIfExists('products');
    }
};
