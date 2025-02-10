<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use App\Models\Orders;
use App\Models\Checkout;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function createTransaction(Request $request)
    {
        $orderId = rand(); // Generate a unique order ID
        $grossAmount = $request->input('amount'); // Amount from the request

        // Call the Midtrans service without customer details
        $snapToken = $this->midtransService->createTransaction($orderId, $grossAmount);

        return response()->json(['snap_token' => $snapToken]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        $input = $request->validate([
            'user' => ['required'],
            'menu' => ['required', 'array'],
            'quantity' => ['required', 'array']
        ]);

        $user_id = User::where('name', $input['user'])->first();
        $order = Orders::create([
            'user_id' => $user_id->id
        ]);

        if (count($input['menu']) !== count($input['quantity'])) {
            return response()->json(['message' => 'Menu and quantity mismatch'], 400);
        }
    
        // Loop through each menu item and store in order_items
        foreach ($input['menu'] as $index => $menuName) {
            // Find the product ID from the 'menus' table
            $menu = Menu::where('name', $menuName)->first();
    
            if (!$menu) {
                return response()->json(['message' => "Menu item '$menuName' not found"], 404);
            }
    
            OrderItems::create([
                'order_id' => $order->id,
                'menu_id' => $menu->id, // Store product ID
                'quantity' => $input['quantity'][$index]
            ]);
        }

        return response()->json([
            'message' => 'berhasil masuk datanya',
            'order_id' => $order->id
        ]);
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
