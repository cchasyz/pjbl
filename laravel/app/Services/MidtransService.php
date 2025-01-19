<?php
namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function createTransaction($orderId, $grossAmount, $customerDetails = null)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
        ];

        // Add customer details only if provided
        if ($customerDetails) {
            $params['customer_details'] = $customerDetails;
        }

        return Snap::getSnapToken($params);
    }
}
