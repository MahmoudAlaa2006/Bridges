<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->string('assessment_id', 50)->nullable();
            $table->string('candidate_id', 50)->nullable();
            $table->string('job_id', 50)->nullable();
            $table->dateTime('start_timestamp')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->enum('status', ['ACTIVE', 'SUBMITTED', 'FLAGGED', 'GRADED', 'COOLDOWN'])->default('ACTIVE');
            $table->tinyInteger('flagged_for_review')->default(0);
            $table->integer('focus_loss_count')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
