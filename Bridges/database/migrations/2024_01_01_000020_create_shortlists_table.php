<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shortlists', function (Blueprint $table) {
            $table->increments('job_slot_id');
            $table->unsignedInteger('application_id')->nullable();
            $table->timestamps();

            $table->foreign('application_id')
                  ->references('application_id')->on('applications')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shortlists');
    }
};
