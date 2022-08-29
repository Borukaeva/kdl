<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatBiomaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('biomaterial');
        Schema::create('biomaterials', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->string('name');
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
        Schema::create('biomaterial', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::dropIfExists('biomaterials');
    }
}
