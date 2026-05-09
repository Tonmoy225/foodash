@extends('layouts.admin')
@section('page-title', $user->name . ' — Client Detail')

@section('content')
<div class="order-detail-grid">
    <div class="admin-card">
        <h3>👤 Client Info</h3>
        <div class="client-profile">
            <div class="client-avatar">{{ strtoupper(substr($user->name,0,1)) }}</div>
            <div>
                <h2>{{ $user->name }}</h2>
                <p>{{ $user->email }}</p>
            </div>
        </div>
        <hr>
        <p><strong>Phone:</strong> {{ $user->phone ?? 'Not provided' }}</p>
        <p><strong>Address:</strong> {{ $user->address ?? 'Not provided' }}</p>
        <p><strong>Joined:</strong> {{ $user->created_at->format('d M Y') }}</p>
        <p><strong>Total Orders:</strong> {{ $orders->total() }}</p>
    </div>

    <div class="admin-card">
        <h3>📦 Order History</h3>
        @foreach($orders as $order)
        <div class="order-item-row" style="padding:.75rem 0;border-bottom:1px solid var(--border)">
            <div>
                <strong>#{{ $order->order_number }}</strong><br>
                <small>{{ $order->created_at->format('d M Y') }}</small>
            </div>
            {!! $order->status_badge !!}
            <span>৳{{ number_format($order->total, 0) }}</span>
            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-sm">View</a>
        </div>
        @endforeach
        {{ $orders->links() }}
    </div>
</div>
@endsection
