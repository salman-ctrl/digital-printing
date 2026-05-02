<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function export()
    {
        $orders = Transaction::with('user')->latest()->paginate(10);

        $filename = "transaksi-" . date('Y-m-d_H-i-s') . ".csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $columns = ['Order ID', 'Pelanggan', 'Tanggal', 'Total', 'Status'];

        $callback = function () use ($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_code,
                    $order->user->name ?? '-',
                    $order->created_at,
                    $order->total_price,
                    $order->status
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function index()
    {
        $orders = \App\Models\Transaction::with('user')->latest()->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Request $request, $id)
    {
        $order = \App\Models\Transaction::with(['user', 'details.specification.product'])->findOrFail($id);

        if ($request->routeIs('admin.*')) {
            return view('admin.orders.show', compact('order'));
        }

        // Pastikan user hanya bisa melihat pesanan miliknya sendiri
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('pages.user.orders.show', compact('order'));
    }

    public function history()
    {
        return view('admin.orders.history');
    }
}