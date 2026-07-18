<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia("Welcome",[
        'message' => "Hello Inertia Vue"
    ]);
});
