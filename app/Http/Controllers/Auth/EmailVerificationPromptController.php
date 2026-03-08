<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailVerificationPromptController extends Controller
{
    /**
     * Figyelmeztetés az e-mail megerősítésre.
     */
    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        return $request->user()->hasVerifiedEmail()
                    ? response()->json(['message' => 'Az e-mail cím már meg van erősítve!'], 200)
                    : response()->json(['message' => 'Kérem, erősítse meg az e-mail címet a folytatáshoz!'], 403);
    }
}