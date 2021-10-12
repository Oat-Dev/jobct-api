<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaProvincesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_provinces', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name_th');
            $table->string('name_en');
            $table->foreignId('area_geography_id');
            $table->foreign('area_geography_id')->references('id')->on('area_geographies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('area_provinces');
    }
}
