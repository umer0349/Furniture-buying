<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function admin()
    {
        $countuser = User::count();
        $countorder = Order::count();
        return view('Admin_dashboard', compact('countuser', 'countorder'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


        $products = Product::paginate(3);

        return view('admin.products.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateddata =  $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',

        ]);
        if ($request->hasFile('image')) {
            $image = ($request->file('image'));
            $imgname = rand(100, 1000) . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('gallery/product'), $imgname);
        }
        Product::create([

            'title' => $validateddata['title'],
            'price' => $validateddata['price'],
            'image' => $imgname,
        ]);

        return redirect()->back()->with('success', 'Product added successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function showorders()
    {
        $orders = Order::paginate(3);
        return view('admin.orders.show', compact('orders'));
    }
    public function editproduct($id)
    {

        $edit = Product::find($id);
        return view('admin.products.edit', compact('edit'));
    }
    public function updateproduct(Request $request, $id)
    {
        $product = Product::find($id);

        $validateddata =  $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|mimes:jpg,png',
        ]);
        if ($request->hasFile('image')) {
            $image = ($request->file('image'));
            $imgname = rand(100, 1000) . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('gallery/product'), $imgname);
            $product->image = $imgname;
        }
        $product->title = $request->title;
        $product->price = $request->price;
        $product->save();

        return redirect()->route('product.create')->with('success', 'Product updated successfully!');
    }
    public function deleteproduct($id)
    {
        $productdelete = Product::find($id);
        $productdelete->delete();
        return redirect()->back()->with('success', 'Product deleted successfully!');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function orderdetail($id)
    {
        $orderdetail = Order::with('items.product')->find($id);

        if (!$orderdetail) {
            return back()->with('error', 'Order not found.');
        }

        // Debugging: Check if data is coming
        // dd($orderdetail->toArray());

        return view('admin.orders.showdetail', compact('orderdetail'));
    }

    public function deleteorder($id)
    {
        $order = Order::find($id);
        $order->delete();
        return back();
    }
     public function showusers()
     {
        $allusers=User::paginate(3);
        return view('admin.users.show',compact('allusers'));
     }
     public function deleteusers($id)
     {
        $allusers=User::find($id);
        $allusers->delete();
        return to_route('user.show');
     }
     
}
