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
        Schema::create('teacher_activities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('teacher_id')
                ->constrained()
                ->onDelete('cascade');

            // assignments
            $table->integer('total_assignments')->default(0);
            $table->integer('checked_assignments')->default(0);
            $table->integer('pending_assignments')->default(0);

            // attendance
            $table->integer('total_classes')->default(0);
            $table->string('attendance_avg', 5)->nullable();

            // students status
            $table->integer('eligible_students')->default(0);
            $table->integer('detained_students')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_activities');
    }
};
