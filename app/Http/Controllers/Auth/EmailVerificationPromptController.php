<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailVerificationPromptController extends Controller
{
    /**
     * Figyelmeztetés az e-mail megerősítésre.
     */
    public function __invoke(Request $request): \Illuminate\Http\RedirectResponse|\Illuminate\View\View
    {
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(route('dashboard', absolute: false))
                    : view('auth.verify-email');
    }
}