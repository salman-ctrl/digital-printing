<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Simple income analysis
        $totalIncome = Transaction::where('status', 'paid')->sum('total_price');
        $incomeByMonth = Transaction::where('status', 'paid')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total_price) as total'))
            ->groupBy('month')
            ->get();

        $categories = Category::withCount(['products as orders_count' => function($query) {
            $query->join('cart_details', 'products.id', '=', 'cart_details.product_id')
                  ->join('transactions', 'cart_details.id', '=', 'transactions.id'); // Simplified logic
        }])->get();

        return view('categories.index', compact('categories', 'totalIncome', 'incomeByMonth'));
    }
}
