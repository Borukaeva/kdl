<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalysisBiomaterialPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analysis_biomaterial_price', function (Blueprint $table) {
            $table->id();
            $table->foreignId('analysis_biomaterial_id')->constrained('analysis_biomaterial');
            $table->foreignId('price_id')->constrained('price');
            $table->float('price1', 8, 2)->default(0);
            $table->float('price2', 8, 2)->default(0);
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
        Schema::dropIfExists('analysis_biomaterial_price');
    }
}
