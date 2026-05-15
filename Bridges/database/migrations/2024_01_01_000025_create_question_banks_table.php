<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('question_banks', function (Blueprint $table) {
            $table->increments('question_id');
            $table->unsignedInteger('job_id')->nullable();
            $table->string('text', 500)->nullable();
            $table->enum('difficulty', ['EASY', 'MEDIUM', 'HARD'])->default('MEDIUM');
            $table->string('topic', 50)->nullable();
            $table->decimal('points', 19, 0)->nullable();
            $table->timestamps();

            $table->foreign('job_id')
                  ->references('job_id')->on('jobs')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_banks');
    }
};
