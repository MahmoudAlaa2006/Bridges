<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $blueprint) {
            $blueprint->decimal('exam_score', 5, 2)->nullable()->after('match_score');
            $blueprint->json('answers')->nullable()->after('exam_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $blueprint) {
            $blueprint->dropColumn(['exam_score', 'answers']);
        });
    }
};
