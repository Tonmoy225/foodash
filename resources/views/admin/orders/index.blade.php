@extends('layouts.admin')
@section('page-title', 'Manage Orders')

@section('content')
<div class="filter-tabs">
    @foreach(['','pending','confirmed','preparing','on_the_way','delivered','cancelled'] as $s)
    <a href="{{ route('admin.orders.index', $s ? ['status'=>$s] : []) }}"
       class="filter-tab {{ request('status') == $s ? 'active' : '' }}">
        {{ $s ? ucwords(str_replace('_',' ',$s)) : 'All' }}
    </a>
    @endforeach
</div>

<div class="admin-card">
    <div class="table-wrap">
        <table class="admin-table">
            <thead>
                <tr><th>Order #</th><th>Client</th><th>Total</th><th>Payment</th><th>Status</th><th>Date</th><th>Action</th></tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td><strong>{{ $order->order_number }}</strong></td>
                    <td>{{ $order->user->name }}<br><small>{{ $order->user->phone }}</small></td>
                    <td>৳{{ number_format($order->total, 0) }}</td>
                    <td><span class="badge {{ $order->payment_status === 'paid' ? 'badge-success' : 'badge-warning' }}">{{ ucfirst($order->payment_status) }}</span></td>
                    <td>{!! $order->status_badge !!}</td>
                    <td>{{ $order->created_at->format('d M, H:i') }}</td>
                    <td><a href="{{ route('admin.orders.show', $order->id) }}" class="btn-sm">Manage</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $orders->links() }}
</div>
@endsection
