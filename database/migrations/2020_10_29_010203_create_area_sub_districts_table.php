<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaSubDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_sub_districts', function (Blueprint $table) {
            $table->id();
            $table->string('zip_code');
            $table->string('name_th');
            $table->string('name_en');
            $table->foreignId('area_district_id');
            $table->foreign('area_district_id')->references('id')->on('area_districts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('area_sub_districts');
    }
}
