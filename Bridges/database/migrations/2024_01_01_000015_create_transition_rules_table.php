<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transition_rules', function (Blueprint $table) {
            $table->increments('rule_id');
            $table->unsignedInteger('requisition_id')->nullable();
            $table->string('from_stage', 50)->nullable();
            $table->string('to_stage', 50)->nullable();
            $table->integer('min_match_score')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transition_rules');
    }
};
