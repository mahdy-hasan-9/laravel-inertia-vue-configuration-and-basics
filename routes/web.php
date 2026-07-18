<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia("Welcome", [
        'message' => "Hello Inertia Vue"
    ]);
})->name('home');


Route::get('/about', function () {
    return Inertia("About", [
        'message' => "This is about page"
    ]);
})->name('about');
