<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TopsisResult;
use App\Models\TopsisLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Public dashboard
    public function public()
    {
        $categories = Category::all();
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalOrders = Transaction::count();

        return view('pages.public.home', compact(
            'categories',
            'totalProducts',
            'totalCategories',
            'totalOrders'
        ));
    }

    public function unreadCount()
{
    $count = \App\Models\Order::where('status', 'pending')->count();

    return response()->json([
        'count' => $count
    ]);
}

    // Dashboard khusus user login
    public function index()
    {
        $user = auth()->user();
        $totalOrders = Transaction::where('user_id', $user->id)->count();
        $paidOrders = Transaction::where('user_id', $user->id)->where('status', 'paid')->count();
        $pendingOrders = Transaction::where('user_id', $user->id)->where('status', 'pending')->count();
        
        // Total pengeluaran (hanya yang lunas)
        $totalSpent = Transaction::where('user_id', $user->id)
            ->where('status', 'paid')
            ->sum('total_price');

        $latestOrders = Transaction::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $cartCount = \App\Models\CartDetail::whereHas('cart', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->count();

        $recommendedProducts = Product::with('category')->latest()->take(4)->get();

        return view('pages.user.dashboard', compact(
            'totalOrders', 
            'paidOrders', 
            'pendingOrders', 
            'totalSpent',
            'latestOrders',
            'cartCount',
            'recommendedProducts'
        ));
    }

    // Dashboard Admin
    public function adminIndex()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_transactions' => Transaction::count(),
            'recent_transactions' => Transaction::with('user')->latest()->take(5)->get(),
            'recent_topsis' => TopsisLog::with(['user', 'category'])->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    // Dashboard Owner
    public function ownerIndex()
    {
        // 1. Laporan Penjualan
        $sales_report = [
            'total_revenue' => Transaction::where('status', 'paid')->sum('total_price'),
            'total_paid' => Transaction::where('status', 'paid')->count(),
            'total_pending' => Transaction::where('status', 'pending')->count(),
            'monthly_sales' => Transaction::where('status', 'paid')
                ->whereMonth('created_at', now()->month)
                ->sum('total_price'),
        ];

        // 2. Hasil TOPSIS (Logs)
        $topsis_results = TopsisLog::with(['user', 'category'])
            ->latest()
            ->take(10)
            ->get();

        // 3. Statistik Produk (Top 5 Paling Laris)
        $product_stats = DB::table('transaction_details')
            ->join('product_specifications', 'transaction_details.product_specification_id', '=', 'product_specifications.id')
            ->join('products', 'product_specifications.product_id', '=', 'products.id')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->where('transactions.status', 'paid')
            ->select('products.name', DB::raw('SUM(transaction_details.quantity) as total_sold'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        return view('owner.dashboard', compact('sales_report', 'topsis_results', 'product_stats'));
    }
}
