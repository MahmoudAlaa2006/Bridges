<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->increments('submission_id');
            $table->unsignedBigInteger('assessment_id')->nullable();
            $table->dateTime('submitted_at')->nullable();
            $table->enum('submission_type', ['MANUAL_SUBMIT', 'AUTO_SUBMIT'])->default('MANUAL_SUBMIT');
            $table->tinyInteger('plagiarism_flag')->default(0);
            $table->string('matched_template_id', 50)->nullable();
            $table->decimal('similarity_score', 19, 0)->nullable();
            $table->decimal('total_score', 19, 0)->nullable();
            $table->timestamps();

            $table->foreign('assessment_id')
                  ->references('id')->on('assessments')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
