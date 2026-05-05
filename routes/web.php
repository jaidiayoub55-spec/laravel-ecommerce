<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

Route::get('/image/{path}', function ($path) {
    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }

    $file = Storage::disk('public')->get($path);
    $type = Storage::disk('public')->mimeType($path);

    return Response::make($file, 200, [
        'Content-Type' => $type,
    ]);
})->where('path', '.*');

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
