<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function __invoke()
    {
        return inertia("About", [
            'message' => "This is about page"
        ]);
    }
}
