<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->text('feedback_text')->nullable()->after('score');
            $table->text('escalation_reason')->nullable()->after('feedback_text');
            $table->boolean('is_escalated')->default(false)->after('escalation_reason');
            $table->timestamp('submitted_at')->nullable()->after('is_escalated');
            // Remove old comments column if exists (safe rename/drop)
            if (Schema::hasColumn('feedbacks', 'comments')) {
                $table->dropColumn('comments');
            }
        });

        Schema::create('interview_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('interview_id');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->string('status')->default('active'); // active, ended
            $table->timestamps();

            $table->foreign('interview_id')
                  ->references('id')->on('interviews')
                  ->onDelete('cascade');
        });

        Schema::create('time_extension_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('interview_id');
            $table->unsignedInteger('requested_by');
            $table->integer('requested_minutes');
            $table->string('reason')->nullable();
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->timestamps();

            $table->foreign('interview_id')
                  ->references('id')->on('interviews')
                  ->onDelete('cascade');
            $table->foreign('requested_by')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('time_extension_requests');
        Schema::dropIfExists('interview_sessions');
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->string('comments', 500)->nullable();
            $table->dropColumn(['feedback_text', 'escalation_reason', 'is_escalated', 'submitted_at']);
        });
    }
};
