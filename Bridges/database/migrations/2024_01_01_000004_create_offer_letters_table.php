<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offer_letters', function (Blueprint $table) {
            $table->unsignedInteger('offer_id')->primary();
            $table->string('content', 50)->nullable();
            $table->string('create_date', 50)->nullable();
            $table->timestamps();

            $table->foreign('offer_id')
                  ->references('id')->on('offers')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offer_letters');
    }
};
