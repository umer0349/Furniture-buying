<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['addToCart']);
    }

    public function user()
    {
        $totalcount = 0;
        if (auth()->check()) {
            $totalcount = Cart::where('user_id', auth()->id())->count();
        }

        $products = Product::all();

        return view('usersite', compact('products', 'totalcount'));
    }

    public function addToCart(Request $request)
    {
        // dd($request->all());
        $product = Product::find($request->product_id);
        $total = $product->price * $request->quantity;
        $user = auth()->user()->id;
        $exsistingproduct = Cart::where('product_id', $request->product_id)
            ->where('user_id', auth()->user()->id)->first();
        if ($exsistingproduct) {
            $exsistingproduct->quantity = $request->quantity;
            $exsistingproduct->total_price = $total;
            $exsistingproduct->update();
        } else {

            Cart::create([
                'user_id' => $user,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'total_price' => $total,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function showcart()
    {
        $totalcount = 0;
        if (auth()->check()) {
            $totalcount = Cart::where('user_id', auth()->id())->count();
        }
        $carts = Cart::where('user_id', auth()->user()->id)->get();

        return view('show_cart', compact('carts', 'totalcount'));
    }

    public function deleteCart($id)
    {
        $carts = Cart::findOrFail($id);
        $carts->delete();

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {}
}
