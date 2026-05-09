<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function history()
    {
        $orders = Order::where('user_id', Auth::id())
                       ->with('items.product')
                       ->latest()
                       ->paginate(10);
        return view('client.history.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);
        $order->load('items.product', 'voucher');
        return view('client.history.show', compact('order'));
    }

    public function track(Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);
        return view('client.tracking.index', compact('order'));
    }

    public function getLocation(Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);
        $loc = $order->location;
        return response()->json([
            'status' => $order->status,
            'lat'    => $loc ? $loc->lat : 23.8103,
            'lng'    => $loc ? $loc->lng : 90.4125,
        ]);
    }
}
