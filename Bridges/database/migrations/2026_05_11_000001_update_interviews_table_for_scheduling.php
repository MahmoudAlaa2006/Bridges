<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('interviews', function (Blueprint $table) {
            $table->dropColumn('is_finish');
            $table->string('status')->default('scheduled'); // scheduled, completed, pending_feedback
            $table->unsignedInteger('application_id')->nullable()->after('user_id');
            $table->text('presentation_notes')->nullable()->after('content');

            $table->foreign('application_id')
                  ->references('application_id')->on('applications')
                  ->onDelete('set null');
        });

        Schema::table('briefs', function (Blueprint $table) {
            $table->text('content')->change(); // Allow larger content for briefs
        });
    }

    public function down(): void
    {
        Schema::table('interviews', function (Blueprint $table) {
            $table->dropForeign(['application_id']);
            $table->dropColumn(['status', 'application_id', 'presentation_notes']);
            $table->tinyInteger('is_finish')->default(0);
        });

        Schema::table('briefs', function (Blueprint $table) {
            $table->string('content', 255)->change();
        });
    }
};
