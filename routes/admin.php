<?php

use Illuminate\Support\Facades\Route;

 Route::get('admin', function () {
    return to_route('admin.dashboard');
 });

Route::middleware(['auth','admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('dashboard', function () {
        return Inertia("backend/dashboard/Dashboard", [
            'message' => "Hello Backend Inertia Vue"
        ]);
    })->name('dashboard');
});
