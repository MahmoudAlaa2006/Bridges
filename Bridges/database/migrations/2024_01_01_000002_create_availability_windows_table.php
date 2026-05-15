<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('availability_windows', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('candidate_user_id');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('time_zone', 50);
            $table->timestamps();

            $table->foreign('candidate_user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('availability_windows');
    }
};
