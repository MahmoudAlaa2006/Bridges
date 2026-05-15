<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('escalation_logs', function (Blueprint $table) {
            $table->increments('escalation_id');
            $table->unsignedInteger('interview_id')->nullable();
            $table->dateTime('reminder_sent_at')->nullable();
            $table->dateTime('escalation_sent_at')->nullable();
            $table->dateTime('resolved_at')->nullable();
            $table->timestamps();

            $table->foreign('interview_id')
                  ->references('id')->on('interviews')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('escalation_logs');
    }
};
