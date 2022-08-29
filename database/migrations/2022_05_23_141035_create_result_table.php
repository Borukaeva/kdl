<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('result', function (Blueprint $table) {
            $table->id();
            $table->foreignId('analysis_id')->constrained('analysis');
            $table->foreignId('analysis_biomaterial_id')->constrained('analysis_biomaterial');
            $table->foreignId('analysis_parameter_id')->constrained('analysis_parameter');
            $table->integer('status');
            $table->string('result');
            $table->foreignId('laborant_id')->constrained('user');
            $table->dateTime('date_result');
            $table->foreignId('ticket_id')->constrained('ticket');
            $table->integer('price');
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
        Schema::dropIfExists('result');
    }
}
