<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function login(Request $request): RedirectResponse{

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended('dashboard')
                ->with('success', 'Login successful!');

        }

        return redirect('login')
            ->withErrors('Login details are not valid');
    }

    public function registration(Request $request): RedirectResponse{

        $request->validate([
            'name' => 'required',
            'handphone' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:8',
        ]);

        $data = $request->all();
        $user = $this->create($data);

        Auth::login($user);

        return redirect('login')
            ->with('success', 'Registration successful! Please login.');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'handphone' => $data['handphone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard');
        }

        return redirect('login')
            ->withErrors('You are not allowed to access');
    }

    public function logout(Request $request): RedirectResponse
    {
        Session::flush();
        Auth::logout();

        return redirect('login');
    }
}
