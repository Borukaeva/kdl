<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnHideInPriceToAnalysisBiomaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('analysis_biomaterial', function (Blueprint $table) {
            $table->boolean('hide_in_price')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('analysis_biomaterial', function (Blueprint $table) {
            $table->dropColumn('hide_in_price');
        });
    }
}
