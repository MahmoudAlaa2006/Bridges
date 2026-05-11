<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->increments('resource_id');
            $table->string('entity_type', 100)->nullable();
            $table->integer('entity_id')->nullable();
            $table->string('action', 50)->nullable();
            $table->integer('granted')->nullable();
            $table->string('user_role', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
