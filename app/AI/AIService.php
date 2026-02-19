<?php

namespace App\AI;
use Gemini\Client;

use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Auth;

class AIService
{
   public static function ask(string $question): string
{
    try {
        $client = new Client([
            'api_key' => env('GEMINI_API_KEY'),
        ]);

        $response = $client
            ->models()
            ->generateContent([
                'model' => 'gemini-1.5-flash',
                'contents' => $question,
            ]);

        return $response->text();

    } catch (\Exception $e) {
        return "AI Error: " . $e->getMessage();
    }
}

    // public static function ask(string $question): string
    // {
    //     $user = Auth::user();
    //     if (! $user) {
    //         return '<b>Unauthorized</b><br>Please login first.';
    //     }

    //     $systemContext = self::getSystemContext($user);

    //     $prompt = "
    // You are an AI Assistant integrated into a professional Learning Management System (LMS).

    // User Information:
    // - Name: {$user->name}
    // - Role: {$user->role}
    // - Date: ".now()->format('Y-m-d')."

    // Available System Data (Real Database Context):
    // {$systemContext}

    // Critical Rules:
    // 1. If the question relates to attendance, assignments, dashboard stats, or LMS data — use ONLY the provided system data.
    // 2. If the data is not available in the system context, clearly say it is not available.
    // 3. If the question is general (e.g., programming, math, general knowledge), answer normally.
    // 4. Never invent fake LMS data.
    // 5. Maintain a professional academic tone.
    // 6. Use HTML tags like <b> and <br> for formatting.

    // User Question:
    // {$question}
    // ";

    //     try {

    //         $result = Gemini::generativeModel('gemini-1.5-flash')
    //             ->generateContent($prompt);

    //         return $result->text();

    //     } catch (\Exception $e) {

    //         return '<b>⚠ AI Service Unavailable</b><br>Please try again later.';
    //     }
    // }

    private static function getSystemContext($user): string
    {
        if ($user->hasRole('admin')) {
            return AdminBrain::answer('dashboard overview', $user);
        }

        if ($user->hasRole('teacher')) {
            return TeacherBrain::answer('my assignment', $user)."\n".
                   TeacherBrain::answer('attendance', $user);
        }

        if ($user->hasRole('student')) {
            return StudentBrain::answer('pending', $user)."\n".
                   StudentBrain::answer('attendance', $user);
        }

        return 'No specific context available for this role.';
    }
}
