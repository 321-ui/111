<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm(): \Illuminate\Contracts\View\View
    {
        return view('auth.login');
    }

    public function login(Request $request): \Illuminate\Http\RedirectResponse
    {
        /** @var array{email: string, password: string} $credentials */
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['email' => 'Неверный email или пароль']);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if ($user->isInstructor()) {
                return redirect()->route('cabinet');
            }

            return redirect()->route('home');
        }

        return back()->withErrors(['email' => 'Неверный email или пароль']);
    }

    public function showRegistrationForm(): \Illuminate\Contracts\View\View
    {
        return view('auth.register');
    }

    public function register(Request $request): \Illuminate\Http\RedirectResponse
    {
        /** @var array{full_name: string, email: string, password: string, phone: string} $validated */
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone' => 'required|regex:/^\+?[0-9]{10,15}$/',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'visitor';
        $validated['email_verified'] = true;

        User::create($validated);

        return back()->with('success', 'Вы успешно зарегистрированы!');
    }

    public function logout(Request $request): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
