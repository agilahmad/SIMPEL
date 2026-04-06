<?php

namespace App\Http\Controllers;

// use App\Models\User;
// use Illuminate\Http\JsonResponse;
use App\Enums\Role;
use App\Models\User;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
// use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister(){
        return view('auth.register');
    }
    public function register(Request $request) {
        $throttlekey = 'register|' . $request->ip();

        if(RateLimiter::tooManyAttempts($throttlekey, 3)){
            $seconds = RateLimiter::availableIn($throttlekey);

            throw ValidationException::withMessages([
                'email' => "Terlalu banyak percobaan registrasi. Coba lagi dalam {$seconds} detik."
            ]);
        }

        RateLimiter::hit($throttlekey, 600);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'role' => Role::User,
        ]);

        AuditService::log('registered', $user, [], [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role->value,
        ], $user->id);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil. Selamat datang, ' . $user->name . '!');
    }

    public function showLogin(){
        return view('auth.login');
    }

    public function login(Request $request){
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $throttlekey = Str::lower($request->input('email')) . '|' . $request->ip();

        if(RateLimiter::tooManyAttempts($throttlekey, 5)){
            $second = RateLimiter::availableIn($throttlekey);

            AuditService::log('login_blocked', null, [], [
                'email' => $request->input('email'),
                'reason' => 'rate_limit_exceeded',
                'retry_after' => $second,
            ], null);

            throw ValidationException::withMessages([
                'email' => "Terlalu banyak percobaan login. Coba lagi dalam {$second} detik."
            ]);
        }

        if(!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))){
            RateLimiter::hit($throttlekey);

            AuditService::log('log_failed', null, [], [
                'email' => $request->input('email'),
            ], null);

            throw ValidationException::withMessages([
                'email' => 'Email atau password salah.'
            ]);
        }

        RateLimiter::clear($throttlekey);
        $request->session()->regenerate();
        AuditService::logAuth('login', Auth::id());
        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request){
        $userId = Auth::id();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        AuditService::logAuth('logout', $userId);

        return redirect()->route('login');
    }
}
