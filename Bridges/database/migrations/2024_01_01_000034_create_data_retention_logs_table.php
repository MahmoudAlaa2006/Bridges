<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_retention_logs', function (Blueprint $table) {
            $table->id('retention_log_id');
            $table->string('action', 100)->nullable();
            $table->integer('report_id')->nullable();
            $table->integer('candidate_id')->nullable();
            $table->timestamp('action_date')->nullable();
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_retention_logs');
    }
};
