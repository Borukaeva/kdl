<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalysisBiomaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analysis_biomaterials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('analyzes_id')->constrained()->nullable();
            $table->foreignId('biomaterials_id')->constrained()->nullable();
            $table->foreignId('test_tubes_id')->constrained()->nullable();
            $table->integer('result_type');
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
        Schema::dropIfExists('analysis_biomaterials');
    }
}
