<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function createPayment(Request $request){
        $midtransServerKey = env('MIDTRANS_SERVER_KEY');
        $amount = $request->input('amount');
        $invoiceId = 'INV-' . time(); // Unique Invoice ID

        // Replace with your payment provider's endpoint and API key
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode(`$midtransServerKey` . ':'),
        ])->post('https://api.sandbox.midtrans.com/v2/charge', [
            'amount' => $amount,
            'invoice_id' => $invoiceId,
            'description' => 'Payment for Invoice #' . $invoiceId,
            'callback_url' => route('payment.callback'),
        ]);

        if ($response->successful()) {
            $data = $response->json();
        
            // Check if the expected key exists in the response
            if (isset($data['qr_code_url'])) {
                // Save the transaction to your database
                \DB::table('transactions')->insert([
                    'invoice_id' => $invoiceId,
                    'amount' => $amount,
                    'status' => 'pending',
                    'qr_code' => $data['qr_code_url'], // QRIS code URL
                ]);
                return response()->json(['qr_code_url' => $data['qr_code_url']]);
            } else {
                // Handle the case where the QR code URL is not returned
                return response()->json(['error' => 'QR code URL not found in the response'], 500);
            }
        }
        return response()->json(['error' => 'Payment creation failed'], 500);        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function handleWebhook(Request $request){
    $payload = $request->all();

    // Verify the signature or secret (depends on provider)
    if ($payload['status'] === 'success') {
        \DB::table('transactions')
            ->where('invoice_id', $payload['invoice_id'])
            ->update(['status' => 'paid']);
    }

    return response()->json(['message' => 'Webhook received'], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Checkout $checkout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Checkout $checkout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Checkout $checkout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Checkout $checkout)
    {
        //
    }
}
