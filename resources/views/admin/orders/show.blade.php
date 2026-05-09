@extends('layouts.admin')
@section('page-title', 'Order #' . $order->order_number)
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<style>#adminMap{height:350px;border-radius:12px;margin-top:1rem}</style>
@endpush

@section('content')
<div class="order-detail-grid">
    <!-- LEFT: Order Info -->
    <div>
        <div class="admin-card">
            <h3>Order Items</h3>
            @foreach($order->items as $item)
            <div class="order-item-row">
                <span>{{ $item->product->name }}</span>
                <span>× {{ $item->quantity }}</span>
                <span>৳{{ number_format($item->subtotal, 0) }}</span>
            </div>
            @endforeach
            <hr>
            <div class="order-item-row"><span>Subtotal</span><span></span><span>৳{{ number_format($order->subtotal, 0) }}</span></div>
            @if($order->discount > 0)
            <div class="order-item-row text-green"><span>Discount</span><span></span><span>-৳{{ number_format($order->discount, 0) }}</span></div>
            @endif
            <div class="order-item-row"><span>Delivery Fee</span><span></span><span>৳{{ number_format($order->delivery_fee, 0) }}</span></div>
            <div class="order-item-row total-row"><span><strong>Total</strong></span><span></span><span><strong>৳{{ number_format($order->total, 0) }}</strong></span></div>
        </div>

        <div class="admin-card" style="margin-top:1rem">
            <h3>Client Info</h3>
            <p><strong>Name:</strong> {{ $order->user->name }}</p>
            <p><strong>Email:</strong> {{ $order->user->email }}</p>
            <p><strong>Phone:</strong> {{ $order->user->phone ?? 'N/A' }}</p>
            <p><strong>Delivery Address:</strong> {{ $order->delivery_address }}</p>
            <p><strong>Payment:</strong> {{ ucfirst($order->payment_method) }} — <span class="{{ $order->payment_status === 'paid' ? 'text-green' : '' }}">{{ ucfirst($order->payment_status) }}</span></p>
            @if($order->notes)<p><strong>Notes:</strong> {{ $order->notes }}</p>@endif
        </div>
    </div>

    <!-- RIGHT: Status + Map -->
    <div>
        <div class="admin-card">
            <h3>Update Status</h3>
            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                @csrf
                <select name="status" style="width:100%;padding:.75rem;border-radius:8px;margin-bottom:1rem;background:var(--input-bg);color:var(--text-primary);border:1px solid var(--border)">
                    @foreach(['pending','confirmed','preparing','on_the_way','delivered','cancelled'] as $s)
                    <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucwords(str_replace('_',' ',$s)) }}</option>
                    @endforeach
                </select>
                <button class="btn-primary btn-full" type="submit">Update Status</button>
            </form>
        </div>

        <div class="admin-card" style="margin-top:1rem">
            <h3>Delivery Location</h3>
            <p style="font-size:.85rem;color:var(--text-muted)">Click on map to set rider location. Client will see this in real-time.</p>
            <div id="adminMap"></div>
            <button class="btn-primary btn-full" style="margin-top:1rem" onclick="saveLocation()">Save Rider Location 📍</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const existingLat = {{ $order->location ? $order->location->lat : 23.8103 }};
const existingLng = {{ $order->location ? $order->location->lng : 90.4125 }};

const map = L.map('adminMap').setView([existingLat, existingLng], 14);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

const riderIcon = L.divIcon({className:'', html:'<div style="font-size:2rem">🛵</div>', iconSize:[40,40]});
let marker = L.marker([existingLat, existingLng], {icon: riderIcon, draggable: true}).addTo(map);

map.on('click', function(e) {
    marker.setLatLng(e.latlng);
});

function saveLocation() {
    const latlng = marker.getLatLng();
    fetch(`/admin/orders/{{ $order->id }}/location`, {
        method: 'POST',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content},
        body: JSON.stringify({lat: latlng.lat, lng: latlng.lng})
    })
    .then(r => r.json())
    .then(d => alert(d.success ? 'Location updated!' : 'Failed'));
}
</script>
@endpush
