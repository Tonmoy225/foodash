<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    private function getCart(): array
    {
        return Session::get('cart', []);
    }

    private function saveCart(array $cart): void
    {
        Session::put('cart', $cart);
    }

    public function index()
    {
        $cart     = $this->getCart();
        $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);
        $voucher  = Session::get('voucher');
        $discount = $voucher ? $voucher['discount'] : 0;
        $fee      = $subtotal > 0 ? 40 : 0;
        $total    = max(0, $subtotal - $discount + $fee);

        return view('client.cart.index', compact('cart', 'subtotal', 'discount', 'fee', 'total', 'voucher'));
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart    = $this->getCart();
        $key     = $product->id;

        if (isset($cart[$key])) {
            $cart[$key]['qty'] += $request->qty ?? 1;
        } else {
            $cart[$key] = [
                'id'    => $product->id,
                'name'  => $product->name,
                'price' => $product->price,
                'image' => $product->image_url,
                'qty'   => $request->qty ?? 1,
            ];
        }

        $this->saveCart($cart);
        return response()->json(['success' => true, 'count' => count($cart)]);
    }

    public function update(Request $request)
    {
        $cart = $this->getCart();
        if (isset($cart[$request->product_id])) {
            if ($request->qty <= 0) {
                unset($cart[$request->product_id]);
            } else {
                $cart[$request->product_id]['qty'] = $request->qty;
            }
        }
        $this->saveCart($cart);
        return response()->json(['success' => true]);
    }

    public function remove(Request $request)
    {
        $cart = $this->getCart();
        unset($cart[$request->product_id]);
        $this->saveCart($cart);
        return response()->json(['success' => true]);
    }

    public function clear()
    {
        Session::forget(['cart', 'voucher']);
        return response()->json(['success' => true]);
    }

    public function applyVoucher(Request $request)
    {
        $request->validate(['code' => 'required|string']);
        $voucher  = Voucher::where('code', strtoupper($request->code))->first();
        $cart     = $this->getCart();
        $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);

        if (!$voucher || !$voucher->isValid($subtotal)) {
            Session::forget('voucher');
            return response()->json(['success' => false, 'message' => 'Invalid or expired voucher.']);
        }

        $discount = $voucher->calculateDiscount($subtotal);
        Session::put('voucher', [
            'id'       => $voucher->id,
            'code'     => $voucher->code,
            'discount' => $discount,
        ]);

        return response()->json([
            'success'  => true,
            'discount' => $discount,
            'message'  => 'Voucher applied! You save ৳' . number_format($discount, 2),
        ]);
    }
}
