@extends('layouts.client')
@section('title', 'Payment')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Complete <em>Payment</em></h1>
    </div>
</div>

<section class="section">
    <div class="container" style="max-width:600px">
        <div class="payment-box">
            <div class="payment-order-info">
                <h3>Order #{{ $order->order_number }}</h3>
                <div class="payment-amount">৳{{ number_format($order->total, 2) }}</div>
                <div class="payment-method-label">via {{ ucfirst($order->payment_method) }}</div>
            </div>

            @if($order->payment_method === 'bkash')
            <div class="payment-gateway bkash-gate">
                <div class="gateway-logo">📱 bKash Payment</div>
                <p>Send <strong>৳{{ number_format($order->total, 2) }}</strong> to:</p>
                <div class="gate-number">01XXXXXXXXX</div>
                <p class="gate-ref">Reference: <strong>{{ $order->order_number }}</strong></p>
                <form action="{{ route('payment.process', $order->id) }}" method="POST">
                    @csrf
                    <input type="text" name="trx_id" placeholder="Enter bKash Transaction ID" required>
                    <button class="btn-primary btn-full" type="submit">Confirm Payment</button>
                </form>
            </div>

            @elseif($order->payment_method === 'nagad')
            <div class="payment-gateway nagad-gate">
                <div class="gateway-logo">📲 Nagad Payment</div>
                <p>Send <strong>৳{{ number_format($order->total, 2) }}</strong> to:</p>
                <div class="gate-number">01XXXXXXXXX</div>
                <p class="gate-ref">Reference: <strong>{{ $order->order_number }}</strong></p>
                <form action="{{ route('payment.process', $order->id) }}" method="POST">
                    @csrf
                    <input type="text" name="trx_id" placeholder="Enter Nagad Transaction ID" required>
                    <button class="btn-primary btn-full" type="submit">Confirm Payment</button>
                </form>
            </div>

            @elseif($order->payment_method === 'card')
            <div class="payment-gateway card-gate">
                <div class="gateway-logo">💳 Card Payment</div>
                <form action="{{ route('payment.process', $order->id) }}" method="POST">
                    @csrf
                    <div class="card-form">
                        <div class="form-group">
                            <label>Card Number</label>
                            <input type="text" placeholder="4242 4242 4242 4242" maxlength="19" id="cardNum">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Expiry</label>
                                <input type="text" placeholder="MM/YY" maxlength="5">
                            </div>
                            <div class="form-group">
                                <label>CVV</label>
                                <input type="text" placeholder="123" maxlength="3">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Cardholder Name</label>
                            <input type="text" placeholder="Your Name">
                        </div>
                    </div>
                    <button class="btn-primary btn-full" type="submit">Pay ৳{{ number_format($order->total, 2) }}</button>
                </form>
            </div>

            @else
            <!-- Cash on Delivery -->
            <div class="payment-gateway cash-gate">
                <div class="cash-icon">💵</div>
                <h3>Cash on Delivery</h3>
                <p>Pay <strong>৳{{ number_format($order->total, 2) }}</strong> when your order arrives.</p>
                <p class="gate-ref">Please keep exact change ready.</p>
                <form action="{{ route('payment.process', $order->id) }}" method="POST">
                    @csrf
                    <button class="btn-primary btn-full btn-lg" type="submit">Confirm Order →</button>
                </form>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
