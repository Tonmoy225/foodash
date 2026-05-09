@extends('layouts.client')
@section('title', 'Checkout')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Check<em>out</em></h1>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="checkout-layout">
            <!-- ORDER FORM -->
            <form action="{{ route('checkout.place') }}" method="POST" class="checkout-form">
                @csrf
                <div class="checkout-section">
                    <h3>📍 Delivery Address</h3>
                    <div class="form-group">
                        <label>Full Address</label>
                        <textarea name="delivery_address" rows="3" placeholder="House no, Road, Area, City" required>{{ old('delivery_address', $user->address) }}</textarea>
                    </div>
                </div>

                <div class="checkout-section">
                    <h3>💳 Payment Method</h3>
                    <div class="payment-methods">
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="cash" checked>
                            <div class="payment-card">
                                <span class="pay-icon">💵</span>
                                <span>Cash on Delivery</span>
                            </div>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="bkash">
                            <div class="payment-card">
                                <span class="pay-icon">📱</span>
                                <span>bKash</span>
                            </div>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="nagad">
                            <div class="payment-card">
                                <span class="pay-icon">📲</span>
                                <span>Nagad</span>
                            </div>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="card">
                            <div class="payment-card">
                                <span class="pay-icon">💳</span>
                                <span>Debit/Credit Card</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="checkout-section">
                    <h3>📝 Special Notes</h3>
                    <textarea name="notes" rows="2" placeholder="Any special instructions..."></textarea>
                </div>

                <button type="submit" class="btn-primary btn-full btn-lg">
                    Place Order — ৳{{ number_format($total, 0) }} →
                </button>
            </form>

            <!-- ORDER SUMMARY -->
            <div class="checkout-summary">
                <h3>Order Summary</h3>
                @foreach($cart as $item)
                <div class="checkout-item">
                    <div class="checkout-item-name">{{ $item['name'] }}</div>
                    <div class="checkout-item-qty">× {{ $item['qty'] }}</div>
                    <div class="checkout-item-price">৳{{ number_format($item['price'] * $item['qty'], 0) }}</div>
                </div>
                @endforeach
                <hr>
                <div class="summary-row"><span>Subtotal</span><span>৳{{ number_format($subtotal, 0) }}</span></div>
                @if($discount > 0)
                <div class="summary-row text-green"><span>Voucher ({{ $voucher['code'] }})</span><span>-৳{{ number_format($discount, 0) }}</span></div>
                @endif
                <div class="summary-row"><span>Delivery Fee</span><span>৳{{ number_format($fee, 0) }}</span></div>
                <div class="summary-row total-row"><span>Total</span><span>৳{{ number_format($total, 0) }}</span></div>
            </div>
        </div>
    </div>
</section>
@endsection
