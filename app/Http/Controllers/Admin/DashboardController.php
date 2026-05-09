<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Order, Product, User, Voucher};

class DashboardController extends Controller {
    public function index() {
        $stats = [
            'orders'   => Order::count(),
            'revenue'  => Order::where('payment_status','paid')->sum('total'),
            'products' => Product::count(),
            'clients'  => User::where('role','client')->count(),
        ];
        $recent  = Order::with('user')->latest()->take(10)->get();
        $monthly = Order::selectRaw('MONTH(created_at) as month, SUM(total) as revenue')
                        ->whereYear('created_at', date('Y'))
                        ->groupBy('month')->get();
        return view('admin.dashboard.index', compact('stats','recent','monthly'));
    }
}
