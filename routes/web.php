<?php

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


Route::get('products', function () {
    return Inertia("Products", [
        'message' => "This is books page"
    ]);
})->name('products');


Route::get('add/product', function () {
    return Inertia("AddProduct", [
        'message' => "This is Add Product page"
    ]);
})->name('add.product');

Route::get('edit/product/:id', function () {
    return Inertia("EditProduct", [
        'message' => "This is Edit Product page"
    ]);
})->name('product');
