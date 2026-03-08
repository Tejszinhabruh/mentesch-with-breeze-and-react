<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Új megerősítő link küldése.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Az e-mail cím már meg van erősítve!'], 200);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json(['message' => 'Az új megerősítő linket elküldtük a megadott e-mail címre!'], 200);
    }
}