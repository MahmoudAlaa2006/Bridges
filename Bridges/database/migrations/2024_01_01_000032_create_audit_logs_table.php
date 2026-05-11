<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->increments('log_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->integer('actor_id')->nullable();
            $table->string('actor_role', 50)->nullable();
            $table->string('action_type', 50)->nullable();
            $table->timestamp('time_stamp')->nullable();
            $table->string('entity_type', 100)->nullable();
            $table->integer('entity_id')->nullable();
            $table->string('field_changed', 100)->nullable();
            $table->text('value_before')->nullable();
            $table->text('value_after')->nullable();
            $table->string('comments', 500)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
