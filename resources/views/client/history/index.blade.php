@extends('layouts.client')
@section('title', 'Order History')

@section('content')
<div class="page-header">
    <div class="container"><h1>Order <em>History</em></h1></div>
</div>

<section class="section">
    <div class="container">
        @if($orders->count())
        <div class="orders-list">
            @foreach($orders as $order)
            <div class="order-card">
                <div class="order-card-header">
                    <div>
                        <span class="order-number">#{{ $order->order_number }}</span>
                        <span class="order-date">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                    </div>
                    {!! $order->status_badge !!}
                </div>
                <div class="order-items-preview">
                    @foreach($order->items->take(3) as $item)
                    <span>{{ $item->product->name }} ×{{ $item->quantity }}</span>
                    @endforeach
                    @if($order->items->count() > 3)
                    <span class="more-items">+{{ $order->items->count() - 3 }} more</span>
                    @endif
                </div>
                <div class="order-card-footer">
                    <span class="order-total">৳{{ number_format($order->total, 2) }}</span>
                    <div class="order-actions">
                        <a href="{{ route('orders.show', $order->id) }}" class="btn-sm">View Details</a>
                        @if(in_array($order->status, ['confirmed','preparing','on_the_way']))
                        <a href="{{ route('orders.track', $order->id) }}" class="btn-sm btn-accent">Track 📍</a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        {{ $orders->links() }}
        @else
        <div class="empty-state">
            <div class="empty-icon">📦</div>
            <h3>No orders yet</h3>
            <p>Start ordering delicious food!</p>
            <a href="{{ route('menu') }}" class="btn-primary">Browse Menu</a>
        </div>
        @endif
    </div>
</section>
@endsection
