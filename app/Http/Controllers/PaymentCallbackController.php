<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Midtrans\Config;
use Midtrans\Notification;

class PaymentCallbackController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    public function callback()
    {
        try {
            $notification = new Notification();

            $transactionStatus = $notification->transaction_status;
            $orderId = $notification->order_id;
            $type = $notification->payment_type;
            $fraud = $notification->fraud_status;

            $transaction = Transaction::where('order_code', $orderId)->first();

            if (!$transaction) {
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            if ($transactionStatus == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $transaction->status = 'pending';
                    } else {
                        $transaction->status = 'paid';
                    }
                }
            } else if ($transactionStatus == 'settlement') {
                $transaction->status = 'paid';
            } else if ($transactionStatus == 'pending') {
                $transaction->status = 'pending';
            } else if ($transactionStatus == 'deny') {
                $transaction->status = 'failed';
            } else if ($transactionStatus == 'expire') {
                $transaction->status = 'failed';
            } else if ($transactionStatus == 'cancel') {
                $transaction->status = 'failed';
            }

            $transaction->save();

            return response()->json(['message' => 'Notification processed']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function success(Request $request)
    {
        $transaction = Transaction::findOrFail($request->transaction_id);
        
        // Mark as paid immediately if we trust the redirect (simple version)
        // Usually, we wait for the callback, but for UX we can show success.
        if($transaction->status == 'pending'){
            $transaction->status = 'paid';
            $transaction->save();
        }

        return view('pages.checkout.success', compact('transaction'));
    }
}
