<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('briefs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('interview_id')->nullable();
            $table->string('content', 255)->nullable();
            $table->tinyInteger('is_read_only')->default(0);
            $table->dateTime('last_updated')->nullable();
            $table->timestamps();

            $table->foreign('interview_id')
                  ->references('id')->on('interviews')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('briefs');
    }
};
