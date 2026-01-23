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
        Schema::create('student_activities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained()
                ->onDelete('cascade');

            // attendance
            $table->string('attendance_percentage', 5)->nullable();
            $table->integer('classes_attended')->default(0);
            $table->integer('total_classes')->default(0);

            // assignments
            $table->integer('assignments_submitted')->default(0);
            $table->integer('assignments_pending')->default(0);
            $table->integer('assignments_late')->default(0);

            // exam status
            $table->boolean('exam_eligible')->default(true);
            $table->boolean('exam_detained')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_activities');
    }
};
