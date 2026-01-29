<?php

namespace App\Http\Controllers;

use App\AI\AIService;
use Illuminate\Http\Request;

class AIController extends Controller
{
    public function chat(Request $request)
{
    $request->validate([
        'question' => 'required|string',
    ]);

    $reply = AIService::ask($request->question);

    return response()->json([
        'text' => $reply,
    ]);
}

}
