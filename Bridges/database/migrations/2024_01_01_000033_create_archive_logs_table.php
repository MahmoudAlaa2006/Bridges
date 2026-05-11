<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archive_logs', function (Blueprint $table) {
            $table->increments('archive_log_id');
            $table->dateTime('run_date')->nullable();
            $table->string('entity_type', 50)->nullable();
            $table->string('action_type', 50)->nullable();
            $table->integer('record_id')->nullable();
            $table->integer('count_before')->nullable();
            $table->integer('count_after')->nullable();
            $table->longText('record_ids')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archive_logs');
    }
};
