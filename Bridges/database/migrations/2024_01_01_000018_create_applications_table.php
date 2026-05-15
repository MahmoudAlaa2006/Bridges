<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->increments('application_id');
            $table->unsignedInteger('candidate_user_id')->nullable();
            $table->unsignedInteger('job_id')->nullable();
            $table->string('status')->nullable();
            $table->float('match_score')->nullable();
            $table->tinyInteger('shortlisted')->nullable();
            $table->timestamps();

            $table->foreign('candidate_user_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');

            $table->foreign('job_id')
                  ->references('job_id')->on('jobs')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
