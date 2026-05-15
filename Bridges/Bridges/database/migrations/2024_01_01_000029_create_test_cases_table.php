<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_cases', function (Blueprint $table) {
            $table->increments('test_case_id');
            $table->unsignedInteger('code_question_bank_question_id')->nullable();
            $table->string('input', 50)->nullable();
            $table->string('expected_output', 50)->nullable();
            $table->string('actual_output', 50)->nullable();
            $table->tinyInteger('passed')->nullable();
            $table->timestamps();

            $table->foreign('code_question_bank_question_id')
                  ->references('question_bank_question_id')->on('code_questions')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_cases');
    }
};
