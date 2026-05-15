<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grade_results', function (Blueprint $table) {
            $table->unsignedInteger('question_bank_question_id')->primary();
            $table->unsignedInteger('submission_id')->nullable();
            $table->decimal('score', 19, 0)->nullable();
            $table->decimal('max_score', 19, 0)->nullable();
            $table->tinyInteger('passed')->nullable();
            $table->string('attribu_breakdown', 50)->nullable();
            $table->timestamps();

            $table->foreign('question_bank_question_id')
                  ->references('question_id')->on('question_banks')
                  ->onDelete('cascade');

            $table->foreign('submission_id')
                  ->references('submission_id')->on('submissions')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grade_results');
    }
};
