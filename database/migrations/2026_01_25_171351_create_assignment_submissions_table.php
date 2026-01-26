<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();

            // IMPORTANT: manual FK
            $table->unsignedBigInteger('assignment_id');
            $table->unsignedBigInteger('student_id');

            $table->text('answer')->nullable();
            $table->timestamp('submitted_at')->nullable();

            $table->timestamps();

            $table->unique(['assignment_id', 'student_id']);

            // FK → assigns table
            $table->foreign('assignment_id')
                ->references('id')
                ->on('assigns')
                ->onDelete('cascade');

            $table->foreign('student_id')
                ->references('id')
                ->on('students')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignment_submissions');
    }
};
