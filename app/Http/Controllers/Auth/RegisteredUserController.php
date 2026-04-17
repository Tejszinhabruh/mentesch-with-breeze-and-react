<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): \Illuminate\View\View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:50', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ],
        [
            'username.required' => 'A felhasználónév megadása kötelező!' ,
            'username.max' => 'A felhasználónév legfeljebb 50 karakter hosszúságú lehet!',
            'email.required'=>'Az e-mail cím megadása kötelező!',
            'email.lowercase'=>'Az e-mail cím csak karaktereket tartalmazhat!',
            'email.email'=>'Nem megfelelő e-mail formátum! Kérem, valós e-mail címet adjon meg!',
            'email.max'=>'Az e-mail legfeljebb 50 karakter hosszúságú lehet!',
            'email.unique'=>'Ez az e-mail cím már foglalt! Kérem, válasszon másikat!',
            'password.required'=>'A jelszó megadása kötelező!',
            'password.confirmed'=>'A két jelszó nem egyezik meg!    '
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice');
    }
}
