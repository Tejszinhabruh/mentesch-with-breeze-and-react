<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ],
        [
            'current_password.required'=>'A jelenlegi jelszó megadása kötelező!',
            'current_password.current_password'=>'A jelszó helytelen! Kérem, próbálja újra!',
            'password.required'=>'Az új jelszó megadása kötelező!',
            'password.confirmed'=>'Az új jelszavak nem egyeznek! Kérem, próbálja újra!'
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }
}
