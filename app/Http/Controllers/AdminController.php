<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function stats()
{
    return [
        'users' => User::count(),
        'products' => Product::count(),
        'orders' => Order::count(),
        'revenue' => Order::sum('total')
    ];
}
}
