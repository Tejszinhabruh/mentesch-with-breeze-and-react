<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    /**
     * E-mail cím megerősítése a linkre kattintva.
     */
    public function __invoke(EmailVerificationRequest $request): \Illuminate\Http\RedirectResponse
    {
        // Hova irányítsuk a felhasználót a siker után?
        // (Alapértelmezetten a localhost:3000-re, ha nincs beállítva más az .env fájlban)
        $frontendUrl = env('FRONTEND_URL', 'http://localhost:3000');

        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended($frontendUrl . '/dashboard?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended($frontendUrl . '/dashboard?verified=1');
    }
}