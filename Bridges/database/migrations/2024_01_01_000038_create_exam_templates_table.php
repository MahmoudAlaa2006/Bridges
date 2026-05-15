<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_templates', function (Blueprint $table) {
            $table->increments('template_id');
            $table->integer('mcq_easy')->nullable();
            $table->integer('mcq_medium')->nullable();
            $table->integer('mcq_hard')->nullable();
            $table->integer('written')->nullable();
            $table->integer('coding')->nullable();
            $table->unsignedInteger('requisition_id')->nullable();
            $table->timestamps();

            $table->foreign('requisition_id')
                  ->references('requisition_id')->on('job_requisitions')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_templates');
    }
};
