<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;

class LoginController extends Controller
{
    /**
     * Show login form
     */
    public function create(Request $request)
    {
        // Get role from query (?role=teacher)
        $role = $request->query('role', 'student');

        // Validate role
        if (!in_array($role, ['student', 'teacher'])) {
            $role = 'student';
        }

        return view('auth.login', compact('role'));
    }

    /**
     * Handle login submission
     */
    public function store(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
            'role'     => ['required', 'in:student,teacher'],
        ]);

        // Normalize email + role
        $email = strtolower($request->email);
        $role  = strtolower($request->role);

        // Throttle key
        $throttleKey = $email . '|' . $request->ip() . '|' . $role;

        // Too many attempts?
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'email' => "Too many login attempts. Please try again in {$seconds} seconds.",
            ]);
        }

        // Credentials
        $credentials = [
            'email'    => $email,
            'password' => $request->password,
            'role'     => $role,
        ];

        // Attempt login + Remember Me
        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::hit($throttleKey);
            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records.',
            ]);
        }

        // Clear throttle attempts
        RateLimiter::clear($throttleKey);

        // Prevent session fixation
        $request->session()->regenerate();

        // Redirect based on role using named routes
        $user = Auth::user();
        if ($user->role === 'teacher') {
            return redirect()->intended(route('dashboards.hometeacher'));
        }

        return redirect()->intended(route('dashboards.homestudent'));
    }

    /**
     * Logout user
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('status', 'You have been logged out.');
    }
}
