<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mcq_questions', function (Blueprint $table) {
            $table->unsignedInteger('question_bank_question_id')->primary();
            $table->string('options', 255)->nullable();
            $table->integer('correct_option_index')->nullable();
            $table->timestamps();

            $table->foreign('question_bank_question_id')
                  ->references('question_id')->on('question_banks')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mcq_questions');
    }
};
