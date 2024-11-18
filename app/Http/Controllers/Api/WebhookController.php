<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebhookController extends Controller
{
    public function update()
    {
        \Midtrans\Config::$isProduction = (bool) env('MIDTRANS_IS_PRODUCTION', false);
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        $notif = new \Midtrans\Notification();

        $transactionStatus = $notif->transaction_status;
        $orderId = $notif->order_id;
        $fraudStatus = $notif->fraud_status;

        DB::beginTransaction();
        try {

            $status = null;
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    // TODO set transaction status on your database to 'success'
                    // and response with 200 OK
                    $status = 'success';
                }
            } else if ($transactionStatus == 'settlement') {
                // TODO set transaction status on your database to 'success'
                $status = 'success';
                // and response with 200 OK
            } else if (
                $transactionStatus == 'cancel' ||
                $transactionStatus == 'deny' ||
                $transactionStatus == 'expire'
            ) {
                // TODO set transaction status on your database to 'failure'
                $status = 'failure';
                // and response with 200 OK
            } else if ($transactionStatus == 'pending') {
                // TODO set transaction status on your database to 'pending' / waiting payment
                // and response with 200 OK
                $status = 'pending';
            }

            $transaction = Transaction::where('transaction_code', $orderId)->first();

            if ($transaction->status != 'success') {
                $transaction->update(['status' => $status]);

                if ($status == 'success') {
                    $userId = $transaction->user_id;
                    $transactionAmount = $transaction->amount;
                    Wallet::where('user_id', $userId)->increment('balance', $transactionAmount);
                }
            }
            DB::commit();
            return response()->json();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage(), 400]);
        }
    }
}
