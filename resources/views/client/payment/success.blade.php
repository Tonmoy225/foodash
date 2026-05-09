@extends('layouts.client')
@section('title', 'Order Confirmed')

@section('content')
<section class="section">
    <div class="container" style="max-width:600px; text-align:center; padding-top:4rem">
        <div class="success-animation">
            <div class="success-circle">✓</div>
        </div>
        <h1 style="margin-top:2rem">Order <em>Confirmed!</em> 🎉</h1>
        <p style="font-size:1.1rem; margin:1rem 0">
            Your order <strong>#{{ $order->order_number }}</strong> has been placed successfully.
        </p>
        <p>Estimated delivery: <strong>30–45 minutes</strong></p>

        <div class="success-actions" style="margin-top:2rem; display:flex; gap:1rem; justify-content:center">
            <a href="{{ route('orders.track', $order->id) }}" class="btn-primary">Track Order 📍</a>
            <a href="{{ route('orders.history') }}" class="btn-outline">View Orders</a>
        </div>
    </div>
</section>
@endsection
