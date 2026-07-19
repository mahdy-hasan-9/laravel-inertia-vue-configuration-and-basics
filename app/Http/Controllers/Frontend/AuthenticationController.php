<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthenticationController extends Controller
{
    public function register()
    {
        return Inertia("frontend/auth/Register", [
            'message' => "This is register page"
        ]);
    }

    public function login()
    {
        return Inertia("frontend/auth/Login", [
            'message' => "This is login page"
        ]);
    }
}
