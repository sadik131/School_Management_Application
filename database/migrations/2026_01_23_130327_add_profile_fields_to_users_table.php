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
        Schema::table('users', function (Blueprint $table) {
           // basic info
            $table->string('phone')->nullable()->after('email');
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable()->after('phone');
            $table->date('dob')->nullable()->after('gender');
            $table->string('blood', 5)->nullable()->after('dob');
            $table->text('address')->nullable()->after('blood');

            // role
            $table->enum('role', ['admin', 'teacher', 'student'])
                  ->default('student')
                  ->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'gender',
                'dob',
                'blood',
                'address',
                'role',
            ]);
        });
    }
};
