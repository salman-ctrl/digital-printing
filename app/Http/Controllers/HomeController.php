<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')
            ->orderBy('name', 'asc')
            ->get();

        $featuredProducts = Product::with(['category', 'specifications'])
            ->select('products.*', DB::raw('SUM(transaction_details.quantity) as total_sold'))
            ->join('product_specifications', 'product_specifications.product_id', '=', 'products.id')
            ->join('transaction_details', 'transaction_details.product_specification_id', '=', 'product_specifications.id')
            ->groupBy('products.id')
            ->orderByDesc('total_sold')
            ->take(3)
            ->get();

        return view('pages.public.home', compact('categories', 'featuredProducts'));
    }
}