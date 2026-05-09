<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) return redirect()->route('cart');

        $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);
        $voucher  = Session::get('voucher');
        $discount = $voucher ? $voucher['discount'] : 0;
        $fee      = 40;
        $total    = max(0, $subtotal - $discount + $fee);
        $user     = Auth::user();

        return view('client.checkout.index', compact('cart','subtotal','discount','fee','total','user','voucher'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'delivery_address' => 'required|string',
            'payment_method'   => 'required|in:cash,card,bkash,nagad',
        ]);

        $cart = Session::get('cart', []);
        if (empty($cart)) return redirect()->route('cart');

        $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);
        $voucher  = Session::get('voucher');
        $discount = $voucher ? $voucher['discount'] : 0;
        $fee      = 40;
        $total    = max(0, $subtotal - $discount + $fee);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id'          => Auth::id(),
                'voucher_id'       => $voucher['id'] ?? null,
                'order_number'     => Order::generateOrderNumber(),
                'status'           => 'pending',
                'subtotal'         => $subtotal,
                'discount'         => $discount,
                'delivery_fee'     => $fee,
                'total'            => $total,
                'delivery_address' => $request->delivery_address,
                'payment_method'   => $request->payment_method,
                'payment_status'   => 'pending',
                'notes'            => $request->notes,
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item['id'],
                    'quantity'   => $item['qty'],
                    'unit_price' => $item['price'],
                    'subtotal'   => $item['price'] * $item['qty'],
                ]);
            }

            if ($voucher) {
                Voucher::find($voucher['id'])?->increment('used_count');
            }

            DB::commit();
            Session::forget(['cart', 'voucher']);

            return redirect()->route('payment', $order->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Order failed: ' . $e->getMessage()]);
        }
    }

    public function payment(Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);
        return view('client.payment.index', compact('order'));
    }

    public function processPayment(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);

        // Simulate payment processing
        $order->update(['payment_status' => 'paid', 'status' => 'confirmed']);

        return redirect()->route('payment.success', $order->id);
    }

    public function success(Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);
        return view('client.payment.success', compact('order'));
    }
}
