<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('slot_id')->nullable();
            $table->string('content', 50)->nullable();
            $table->dateTime('get_date')->nullable();
            $table->tinyInteger('is_finish')->default(0);
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');

            $table->foreign('slot_id')
                  ->references('id')->on('slots')
                  ->onDelete('set null');
        });

        // Now add the FK on slots → interviews
        Schema::table('slots', function (Blueprint $table) {
            $table->foreign('interview_id')
                  ->references('id')->on('interviews')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('slots', function (Blueprint $table) {
            $table->dropForeign(['interview_id']);
        });
        Schema::dropIfExists('interviews');
    }
};
