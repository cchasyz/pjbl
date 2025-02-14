<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use App\Models\Orders;
use App\Models\OrderItems;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request){
        $input = $request->validate([
            'name' => ['required', 'string']
        ]);

        $user = User::where('name', $input['name'])->first();
        if($user->is_admin == true || !$input){
            return response()->json([
                'message' => 'berhasil admin',
                'data' => $user
            ]);
        }

        if($user || !$input){
            return response()->json([
                'message' => 'berhasil mengambil',
                'data' => $user
            ]);
        }

        $output = User::create([
            'name' => $input['name'],
            'is_admin' => 0
        ]);

        return response()->json([
            'message' => 'berhasil membuat',
            'data' => $output
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getMenu(){
        $menu = Menu::all();

        return response()->json([
            'data' => $menu
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request){
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'price'    => ['required', 'integer', 'min:0'],
            'pic'      => ['required', 'image', 'mimes:jpeg,png,jpg'], 
            'category' => ['required', 'in:All,Best Seller,Favorites'],
        ]);
        
        $path = $request->file('pic')->store('menu', 'public');

        $output = Menu::create([
            'name' => $request->name,
            'price' => $request->price,
            'pic' => 'http://127.0.0.1:8000/storage/' . $path,
            'category' => $request->category
        ]);

        return response()->json([
            'message' => 'done',
            'data' => $output
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function delete($name){
        $menu = Menu::where('name', $name)->first();
        $menu->delete();
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $name){
        $input = $request->validate([
            'name' => ['required'],
            'price' => ['required', 'integer']
        ]);

        $menu = Menu::where('name', $name)->first();

        $menu->update($input);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function getOrders(){
        $order = OrderItems::with('order', 'menu')->get();

        return response()->json([
            'message' => 'berhasil',
            'data' => $order
        ]);
    }
}
