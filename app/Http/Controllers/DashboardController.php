<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction; // pakai ini, bukan Order
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Public dashboard
    public function public()
    {
        $categories = Category::all();
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalOrders = Transaction::count(); // ganti dari Order

        return view('dashboard.public', compact(
            'categories',
            'totalProducts',
            'totalCategories',
            'totalOrders'
        ));
    }

    // Dashboard khusus user login
    public function index()
    {
        return redirect()->route('user.dashboard');
    }
}
