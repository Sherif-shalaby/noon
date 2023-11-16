<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /* +++++++++++++++++++ up() ++++++++++++++++++++  */
    public function up()
    {
        Schema::table('wages', function (Blueprint $table) {
            // $table->addColumn('decimal', 'increases');
            // $table->addColumn('text', 'reasons_of_increases');
            $table->decimal('increases')->nullable()->default(0);
            $table->text('reasons_of_increases')->nullable();
        });
    }

    /* +++++++++++++++++ down() +++++++++++++++++ */
    public function down()
    {
        Schema::table('wages', function (Blueprint $table) {
            $table->dropColumn('increases');
            $table->dropColumn('reasons_of_increases');
        });
    }
};
