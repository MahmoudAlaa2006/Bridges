<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('code_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('interview_id')->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->timestamps();

            $table->foreign('interview_id')
                  ->references('id')->on('interviews')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('code_sessions');
    }
};
