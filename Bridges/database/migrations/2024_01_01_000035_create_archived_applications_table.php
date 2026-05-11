<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archived_applications', function (Blueprint $table) {
            $table->id('archived_app_id');
            $table->unsignedInteger('application_record_id')->nullable();
            $table->integer('candidate_id')->nullable();
            $table->string('status', 50)->nullable();
            $table->timestamp('last_activity_date')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();

            $table->foreign('application_record_id')
                  ->references('application_record_id')->on('application_records')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archived_applications');
    }
};
