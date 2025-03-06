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
        $totalrevenue = Order::sum('subtotal');

        return view('Admin_dashboard', compact('countuser', 'countorder', 'totalrevenue'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $products = Product::all();

        return view('admin.products.create', compact('products'));
    }

    public function listProducts()
    {
        $products = Product::all(); // Fetch all products

        return response()->json([
            'success' => true,
            'products' => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('gallery/product'), $imageName);

        $product = Product::create([
            'title' => $request->title,
            'price' => $request->price,
            'image' => $imageName,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully.',
            'product' => $product,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function showorders(Request $request)
    {
        if ($request->ajax()) {
            $orders = Order::with('user')->withTrashed(); // Soft deleted orders bhi show karne ke liye

            return datatables()->of($orders)
                ->addIndexColumn() // Automatic indexing ke liye
                ->addColumn('user_name', function ($row) {
                    return $row->user->name ?? 'N/A';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M, Y');
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="'.route('orderdtail.show', $row->id).'" class="btn btn-info btn-sm fa fa-eye" title="View"></a>';

                    if ($row->deleted_at == null) {
                        $btn .= ' <a href="'.route('order.delete', $row->id).'" class="btn btn-warning btn-sm fa fa-trash" title="Soft Delete"></a>';
                        $btn .= ' <a href="'.route('order.heard_deleted', $row->id).'" class="btn btn-danger btn-sm fa fa-trash" title="Hard Delete"></a>';
                    } else {
                        $btn .= ' <a href="'.route('order.restore', $row->id).'" class="btn btn-primary btn-sm fa fa-undo" title="Restore"></a>';
                    }

                    return $btn;
                })
                ->rawColumns(['action']) // HTML buttons enable karne ke liye
                ->make(true);
        }

        return view('admin.orders.show'); // Blade file return karega
    }

    public function restoreorders($id)
    {
        $orders = Order::withTrashed()->find($id);
        $orders->restore();

        return back();
    }

    public function headdelete($id)
    {
        $orders = Order::findOrFail($id);

        if (! $orders) {
            return back()->with('error', 'Order not found!');
        }

        $orders->forceDelete();

        return back()->with('success', 'Order deleted successfully!');
    }

    public function editproduct($id)
    {

        $edit = Product::find($id);

        return view('admin.products.edit', compact('edit'));
    }

    public function updateproduct(Request $request, $id)
    {
        $product = Product::find($id);

        $validateddata = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|mimes:jpg,png',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imgname = rand(100, 1000).time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('gallery/product'), $imgname);
            $product->image = $imgname;
        }

        $product->title = $request->title;
        $product->price = $request->price;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully!',
        ]);
    }

    public function deleteproduct($id)
    {
        $productdelete = Product::find($id);
        if ($productdelete) {
            $productdelete->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product not found!',
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function orderdetail($id)
    {
        $orderdetail = Order::with('items.product')->find($id);

        if (! $orderdetail) {
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
        $allusers = User::paginate(3);

        return view('admin.users.show', compact('allusers'));
    }

    public function deleteusers($id)
    {
        $allusers = User::find($id);
        $allusers->delete();

        return to_route('user.show');
    }
}
