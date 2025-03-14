<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Notifications\NewOrder;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {

        // Set Stripe API key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Create a new Checkout Session
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'total amount',  // You can dynamically set this
                        ],
                        'unit_amount' => $request->subtotal * 100,  // Stripe requires the amount in cents
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('payment.success', ['subtotal' => $request->subtotal]),
            'cancel_url' => route('payment.cancel'),
        ]);

        // Return to the Stripe Checkout page
        return redirect($session->url);
    }

    public function success(Request $request)
    {

        // Retrieve the session ID from the request (you can use it to verify the payment)
        $sessionId = $request->get('session_id');

        // You can verify the session here (not shown for brevity)

        // Store the order details
        $order = Order::create([
            'order_number' => 'ORD-'.strtoupper(uniqid()), // Generate a unique order number
            'user_id' => auth()->id(), // Assuming the user is logged in
            'subtotal' => $request->subtotal, // Store the subtotal
            'status' => 'completed', // Update the status to 'completed' after a successful payment
        ]);
        $user = auth()->user();
        $cartitems = $user->cart;
        foreach ($cartitems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->total_price,

            ]);
        }

        $user->cart()->delete();

        $admin = User::role('admin')->first(); // Pehla admin user
        if ($admin) {
            $admin->notify(new NewOrder($order));
        }

        return view('payment.success');
    }

    public function cancel()
    {
        // Handle cancelled payment here
        return view('payment.cancel');
    }
}
