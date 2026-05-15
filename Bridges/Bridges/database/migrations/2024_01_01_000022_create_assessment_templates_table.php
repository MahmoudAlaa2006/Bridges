<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessment_templates', function (Blueprint $table) {
            $table->increments('job_id');
            $table->integer('easy_count')->nullable();
            $table->integer('medium_count')->nullable();
            $table->integer('hard_count')->nullable();
            $table->string('status', 50)->nullable();
            $table->string('topics', 50)->nullable();
            $table->tinyInteger('randomise_order')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_templates');
    }
};
