<?php

use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\AuthenticationController;
use App\Http\Controllers\Frontend\ConversationController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return to_route('home');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/conversation', [ConversationController::class,'index'])->name('conversation.index');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profle', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('add/product', function () {
        return Inertia("product/AddProduct", [
            'message' => "This is Add Product page"
        ]);
    })->name('add.product');
    Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');
});

Route::get('/home', function () {
    return Inertia("Home", [
        'message' => "Hello Inertia Vue"
    ]);
})->name('home');
Route::resource('products', ProductController::class);

Route::middleware(['guest'])->group(function () {
    Route::get('/register', [AuthenticationController::class, 'register'])->name('register');
    Route::post('/register', [AuthenticationController::class, 'registerStore'])->name('register.store');
    Route::get('/login', [AuthenticationController::class, 'login'])->name('login');
    Route::post('/login', [AuthenticationController::class, 'loginStore'])->name('login.store');
});
