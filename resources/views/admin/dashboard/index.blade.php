@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- STATS -->
<div class="stat-cards">
    <div class="stat-card">
        <div class="stat-icon" style="background:#e4002b">📦</div>
        <div class="stat-info">
            <span class="stat-value">{{ number_format($stats['orders']) }}</span>
            <span class="stat-label">Total Orders</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#10b981">৳</div>
        <div class="stat-info">
            <span class="stat-value">৳{{ number_format($stats['revenue'], 0) }}</span>
            <span class="stat-label">Total Revenue</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#6366f1">🛍️</div>
        <div class="stat-info">
            <span class="stat-value">{{ $stats['products'] }}</span>
            <span class="stat-label">Products</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#f59e0b">👥</div>
        <div class="stat-info">
            <span class="stat-value">{{ $stats['clients'] }}</span>
            <span class="stat-label">Clients</span>
        </div>
    </div>
</div>

<!-- RECENT ORDERS -->
<div class="admin-card">
    <div class="card-header">
        <h3>Recent Orders</h3>
        <a href="{{ route('admin.orders.index') }}" class="btn-sm">View All</a>
    </div>
    <div class="table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Client</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recent as $order)
                <tr>
                    <td><strong>{{ $order->order_number }}</strong></td>
                    <td>{{ $order->user->name }}</td>
                    <td>৳{{ number_format($order->total, 0) }}</td>
                    <td><span class="badge {{ $order->payment_status === 'paid' ? 'badge-success' : 'badge-warning' }}">{{ ucfirst($order->payment_status) }}</span></td>
                    <td>{!! $order->status_badge !!}</td>
                    <td>{{ $order->created_at->format('d M, H:i') }}</td>
                    <td><a href="{{ route('admin.orders.show', $order->id) }}" class="btn-sm">View</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
