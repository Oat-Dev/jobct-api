<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('email')->unique();
            $table->string('tel');
            $table->text('profile_photo_path')->nullable();

            // Company address
            $table->string('address');
            $table->foreignId('area_province_id');
            $table->foreign('area_province_id')->references('id')->on('area_provinces')->onDelete('cascade');
            $table->foreignId('area_district_id');
            $table->foreign('area_district_id')->references('id')->on('area_districts')->onDelete('cascade');
            $table->foreignId('area_sub_district_id');
            $table->foreign('area_sub_district_id')->references('id')->on('area_sub_districts')->onDelete('cascade');

            // User
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('companies');
    }
}
