<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;

class AuthenticationController extends Controller
{
    public function register()
    {
        return Inertia("frontend/auth/Register", [
            'message' => "This is register page"
        ]);
    }


    public function registerStore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        Auth::login($user);
        $request->session()->regenerate();
        return to_route('home');
    }


    public function login()
    {
        return Inertia("frontend/auth/Login", [
            'message' => "This is login page"
        ]);
    }


    public function loginStore(Request $request)
    {

        $data = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return to_route('home');
        }

        return back()->withErrors([
            'email' => __('auth.failed'),
        ])->onlyInput('email');
    }



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return to_route('login');
    }
}
