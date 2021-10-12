<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('amount')->nullable();
            $table->integer('salary')->nullable();

            $table->boolean('optional_work_from_home')->default(false);

            // Company
            $table->foreignId('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('model_has_jobs', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');

            $table->foreignId('job_id');
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');

            $table->integer('salary');
            $table->enum('state', ['new', 'opened', 'in_progress', 'updated', 'interview', 'finished', 'cancelled'])->default('new');
            $table->date('request_interview_date')->nullable();
            $table->time('request_interview_time')->nullable();
            $table->date('interview_date')->nullable();
            $table->time('interview_time')->nullable();

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
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('model_has_jobs');
    }
}
