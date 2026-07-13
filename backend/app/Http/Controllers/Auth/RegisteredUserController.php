<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'registration_code' => ['required', 'string', 'unique:users'],
    ]);

    // 🔥 AUTO ROLE LOGIC
    $role = null;

    if (str_starts_with($request->registration_code, 'STU')) {
        $role = 'student';
    } elseif (str_starts_with($request->registration_code, 'LEC')) {
        $role = 'lecturer';
    } elseif (str_starts_with($request->registration_code, 'ADM')) {
        $role = 'admin';
    } else {
        throw ValidationException::withMessages([
            'registration_code' => 'Invalid code. Use STU, LEC or ADM prefix'
        ]);
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'registration_code' => $request->registration_code,
        'role' => $role,
        'onboarding_status' => 'pending',
    ]);

    event(new Registered($user));

    Auth::login($user);

    return redirect()->route('onboarding');
}
}