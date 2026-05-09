@extends('layouts.client')
@section('title', 'Order #' . $order->order_number)

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Order <em>#{{ $order->order_number }}</em></h1>
    </div>
</div>

<section class="section">
    <div class="container" style="max-width:800px">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem">
            {!! $order->status_badge !!}
            <span style="color:var(--text-muted);font-size:.85rem">{{ $order->created_at->format('d M Y, h:i A') }}</span>
        </div>

        <div class="admin-card" style="background:var(--card-bg);border:1px solid var(--border);border-radius:20px;padding:1.5rem;margin-bottom:1rem">
            <h3 style="margin-bottom:1rem">Items Ordered</h3>
            @foreach($order->items as $item)
            <div style="display:flex;align-items:center;gap:1rem;padding:.75rem 0;border-bottom:1px solid var(--border)">
                <img src="{{ $item->product->image_url }}" width="50" height="50"
                     style="border-radius:10px;object-fit:cover"
                     onerror="this.src='https://via.placeholder.com/50x50/ff6b35/fff?text=F'">
                <div style="flex:1">
                    <div style="font-weight:600">{{ $item->product->name }}</div>
                    <div style="font-size:.8rem;color:var(--text-muted)">৳{{ number_format($item->unit_price,0) }} × {{ $item->quantity }}</div>
                </div>
                <strong style="color:var(--primary)">৳{{ number_format($item->subtotal,0) }}</strong>
            </div>
            @endforeach

            <div style="margin-top:1rem;display:flex;flex-direction:column;gap:.4rem">
                <div style="display:flex;justify-content:space-between;font-size:.9rem">
                    <span>Subtotal</span><span>৳{{ number_format($order->subtotal,0) }}</span>
                </div>
                @if($order->discount > 0)
                <div style="display:flex;justify-content:space-between;font-size:.9rem;color:var(--success)">
                    <span>Discount ({{ $order->voucher->code ?? '' }})</span><span>-৳{{ number_format($order->discount,0) }}</span>
                </div>
                @endif
                <div style="display:flex;justify-content:space-between;font-size:.9rem">
                    <span>Delivery Fee</span><span>৳{{ number_format($order->delivery_fee,0) }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-weight:700;font-size:1.1rem;border-top:1px solid var(--border);padding-top:.75rem;margin-top:.25rem">
                    <span>Total</span><span style="color:var(--primary)">৳{{ number_format($order->total,0) }}</span>
                </div>
            </div>
        </div>

        <div style="background:var(--card-bg);border:1px solid var(--border);border-radius:20px;padding:1.5rem;margin-bottom:1rem">
            <h3 style="margin-bottom:1rem">Delivery Info</h3>
            <p><strong>Address:</strong> {{ $order->delivery_address }}</p>
            <p style="margin-top:.5rem"><strong>Payment:</strong> {{ ucfirst($order->payment_method) }}
                <span style="margin-left:.5rem" class="badge {{ $order->payment_status==='paid' ? 'badge-success' : 'badge-warning' }}">{{ ucfirst($order->payment_status) }}</span>
            </p>
            @if($order->notes)<p style="margin-top:.5rem"><strong>Notes:</strong> {{ $order->notes }}</p>@endif
        </div>

        <div style="display:flex;gap:1rem">
            <a href="{{ route('orders.history') }}" class="btn-outline">← Back to Orders</a>
            @if(in_array($order->status, ['confirmed','preparing','on_the_way']))
            <a href="{{ route('orders.track', $order->id) }}" class="btn-primary">Track Order 📍</a>
            @endif
        </div>
    </div>
</section>
@endsection
