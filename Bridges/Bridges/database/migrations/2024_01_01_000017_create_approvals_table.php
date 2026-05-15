<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approvals', function (Blueprint $table) {
            $table->increments('approval_id');
            $table->unsignedInteger('requisition_id')->nullable();
            $table->unsignedInteger('approver_id')->nullable();
            $table->string('status')->nullable();
            $table->text('reason')->nullable();
            $table->timestamps();

            $table->foreign('requisition_id')
                  ->references('requisition_id')->on('job_requisitions')
                  ->onDelete('set null');

            $table->foreign('approver_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approvals');
    }
};
