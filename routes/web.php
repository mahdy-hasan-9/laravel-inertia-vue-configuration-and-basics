<?php

use App\Http\Controllers\Frontend\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/home', function () {
    return Inertia("Home", [
        'message' => "Hello Inertia Vue"
    ]);
})->name('home');


Route::get('/about', function () {
    return Inertia("About", [
        'message' => "This is about page"
    ]);
})->name('about');


Route::resource('products', ProductController::class);


Route::get('add/product', function () {
    return Inertia("product/AddProduct", [
        'message' => "This is Add Product page"
    ]);
})->name('add.product');

Route::get('edit/product/:id', function () {
    return Inertia("product/EditProduct", [
        'message' => "This is Edit Product page"
    ]);
})->name('product');
