<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('job_id');
            $table->string('title', 200);
            $table->string('department', 100)->nullable();
            $table->string('location', 50)->nullable();
            $table->string('salary_range', 50)->nullable();
            $table->tinyInteger('active')->default(1);
            $table->text('description')->nullable();
            $table->text('benefits')->nullable();
            $table->text('requirements')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
