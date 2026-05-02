<?php

use Illuminate\Support\Facades\Route;

Route::get('/admin', function () {
    return view('admin.dashboard');
});
Route::get('/admin/login', function () {
    return view('admin.login');
});
Route::get('/register', function () {
    return view('auth.register');
});
Route::get('/', function () {
    return view('home');
});
Route::get('/cart', function () {
    return view('cart');
});
Route::get('/edit-product/{id}', function ($id) {
    return view('edit-product', compact('id'));
});
