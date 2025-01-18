<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Midtrans;
use Midtrans\Snap;
use Midtrans\Config;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Configure Midtrans with your Server Key
        Config::$serverKey = env('SB-Mid-server-jeUgq_KGog3ohGV3Y6QkHMnB');
        Config::$clientKey = env('SB-Mid-client-EsgwBSFOo4pWB5OX');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createPayment(Request $request)
    {
        $orderId = 'ORD-' . time(); // Example order ID
        $amount = $request->input('amount'); // Total payment amount

        // Create the transaction data array
        $transactionDetails = [
            'order_id' => $orderId,
            'gross_amount' => $amount,
        ];

        // Define customer details (you may adjust based on your requirements)
        $customerDetails = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'customer@example.com',
            'phone' => '08123456789',
        ];

        // Set the transaction parameters
        $transaction = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
        ];

        // Get the payment URL (Snap Token)
        try {
            $snapToken = Snap::getSnapToken($transaction);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function handleCallback(Request $request)
    {
        // Handle the payment status notification from Midtrans
        $notification = $request->all();
        $orderId = $notification['order_id'];
        $transactionStatus = $notification['transaction_status'];

        // Check the transaction status and update the order
        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            // Payment was successful, mark the order as paid
            // You can update your order database here
        } elseif ($transactionStatus == 'pending') {
            // Payment is pending
        } else {
            // Payment failed, handle accordingly
        }

        return response()->json(['status' => 'OK']);
    }
}
