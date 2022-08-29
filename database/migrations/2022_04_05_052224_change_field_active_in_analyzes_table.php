<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldActiveInAnalyzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('analyzes', function (Blueprint $table) {
            $table->dropColumn('active');
        });
        Schema::table('analyzes', function (Blueprint $table) {
            $table->tinyInteger('active')->after('determination_method');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('analyzes', function (Blueprint $table) {
            $table->dropColumn('active');
        });
        Schema::table('analyzes', function (Blueprint $table) {
            $table->boolean('active')->after('determination_method');
        });
    }
}
