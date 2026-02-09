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
        Schema::table('assignment_submissions', function (Blueprint $table) {
            if (Schema::hasColumn('assignment_submissions', 'answer')) {
                $table->renameColumn('answer', 'answer_text');
            }
             if (!Schema::hasColumn('assignment_submissions', 'marks')) {
                $table->integer('marks')->nullable()->after('answer_text');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assignment_submissions', function (Blueprint $table) {
             if (Schema::hasColumn('assignment_submissions', 'answer_text')) {
                $table->renameColumn('answer_text', 'answer');
            }

            if (Schema::hasColumn('assignment_submissions', 'marks')) {
                $table->dropColumn('marks');
            }
        });
    }
};
