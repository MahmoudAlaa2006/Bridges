<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archived_jobs', function (Blueprint $table) {
            $table->id('archived_job_id');
            $table->unsignedInteger('job_record_id')->nullable();
            $table->string('status', 50)->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();

            $table->foreign('job_record_id')
                  ->references('job_record_id')->on('job_records')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archived_jobs');
    }
};
