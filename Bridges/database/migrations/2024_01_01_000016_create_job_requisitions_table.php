<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_requisitions', function (Blueprint $table) {
            $table->increments('requisition_id');
            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->string('salary_range', 50)->nullable();
            $table->string('department', 100)->nullable();
            $table->text('requirements')->nullable();
            $table->text('benefits')->nullable();
            $table->unsignedInteger('template_id')->nullable();
            $table->unsignedInteger('job_id')->nullable();
            $table->unsignedInteger('rule_id')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();

            $table->foreign('job_id')
                  ->references('job_id')->on('jobs')
                  ->onDelete('set null');

            $table->foreign('rule_id')
                  ->references('rule_id')->on('transition_rules')
                  ->onDelete('set null');
        });

        // Back-fill FK on transition_rules → job_requisitions
        Schema::table('transition_rules', function (Blueprint $table) {
            $table->foreign('requisition_id')
                  ->references('requisition_id')->on('job_requisitions')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('transition_rules', function (Blueprint $table) {
            $table->dropForeign(['requisition_id']);
        });
        Schema::dropIfExists('job_requisitions');
    }
};
