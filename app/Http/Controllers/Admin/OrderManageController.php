<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\DeliveryLocation;
use Illuminate\Http\Request;

class OrderManageController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();
        if ($request->status) $query->where('status', $request->status);
        $orders = $query->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'user', 'voucher');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,preparing,on_the_way,delivered,cancelled']);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Order status updated!');
    }

    public function updateLocation(Request $request, Order $order)
    {
        $request->validate(['lat' => 'required|numeric', 'lng' => 'required|numeric']);
        DeliveryLocation::updateOrCreate(
            ['order_id' => $order->id],
            ['lat' => $request->lat, 'lng' => $request->lng]
        );
        return response()->json(['success' => true]);
    }
}
