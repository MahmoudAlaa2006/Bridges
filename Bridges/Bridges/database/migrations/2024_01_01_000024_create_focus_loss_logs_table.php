<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('focus_loss_logs', function (Blueprint $table) {
            $table->increments('log_id');
            $table->unsignedBigInteger('assessment_id')->nullable();
            $table->enum('event_type', ['TAB_SWITCH', 'WINDOW_BLUR', 'PAGE_UNLOAD', 'COPY_PASTE', 'FOCUS_LOST']);
            $table->dateTime('timestamp')->nullable();
            $table->integer('count')->nullable();
            $table->timestamps();

            $table->foreign('assessment_id')
                  ->references('id')->on('assessments')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('focus_loss_logs');
    }
};
