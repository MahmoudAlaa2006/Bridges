<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->integer('age')->nullable();
            $table->string('email', 50)->unique();
            $table->string('password', 255);
            $table->string('role', 50);
            $table->enum('current_stage', ['technical_test', 'interview', 'offer', 'rejected'])->nullable();
            $table->string('resume', 200)->nullable();
            $table->unsignedInteger('offer_id')->nullable();
            $table->tinyInteger('has_capacity')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
