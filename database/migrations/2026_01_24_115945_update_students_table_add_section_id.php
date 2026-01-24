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
        Schema::table('students', function (Blueprint $table) {

            // ❌ old string-based columns remove
            $table->dropColumn(['course', 'section', 'semester']);

            // ✅ correct relational column
            $table->foreignId('section_id')
                  ->after('user_id')
                  ->constrained('sections')
                  ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['section_id']);
            $table->dropColumn('section_id');

            $table->string('course');
            $table->string('section', 10);
            $table->string('semester', 10);
        });
    }
};




