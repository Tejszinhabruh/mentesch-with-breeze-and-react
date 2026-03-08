<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): \Illuminate\Http\JsonResponse
    {
        return response()->json(['message' => 'Ezt a felületet a frontend (React) kezeli.'], 404);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        // 1. Validáció és magyar hibaüzenetek
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Az e-mail cím megadása kötelező!',
            'email.email' => 'Kérem, egy valós e-mail címet adjon meg!',
        ]);

        // 2. Kísérlet a jelszóvisszaállító link elküldésére
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // 3. Válasz küldése JSON formátumban
        if ($status == Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'A jelszóvisszaállító linket elküldtük a megadott e-mail címre!'], 200);
        }

        // Ha valamiért nem sikerült (pl. nem létezik ilyen e-mail cím az adatbázisban)
        return response()->json([
            'message' => 'Nem sikerült elküldeni a visszaállító linket!',
            'error' => __($status)
        ], 400);
    }
}
