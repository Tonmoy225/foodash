@extends('layouts.client')
@section('title', 'Track Order')
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<style>
#map { height: 400px; border-radius: 16px; }
.tracking-status { display:flex; gap:1rem; margin:2rem 0; flex-wrap:wrap }
.status-step { flex:1; min-width:120px; text-align:center; padding:1rem; background:var(--card-bg); border-radius:12px; border:2px solid transparent }
.status-step.done { border-color: var(--accent); background: rgba(228,0,43,0.1) }
.status-step.current { border-color: var(--primary); animation: pulse 2s infinite }
.step-icon-s { font-size:1.8rem; display:block; margin-bottom:.5rem }
@keyframes pulse { 0%,100%{transform:scale(1)} 50%{transform:scale(1.05)} }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="container"><h1>Track <em>Order</em> #{{ $order->order_number }}</h1></div>
</div>

<section class="section">
    <div class="container">
        <!-- STATUS STEPS -->
        <div class="tracking-status">
            @php
                $steps = ['confirmed'=>'✅','preparing'=>'👨‍🍳','on_the_way'=>'🛵','delivered'=>'🎉'];
                $reached = false;
            @endphp
            @foreach($steps as $step => $icon)
            @php
                $isDone = in_array($order->status, array_slice(array_keys($steps), 0, array_search($step, array_keys($steps))+1));
                $isCurrent = $order->status === $step;
            @endphp
            <div class="status-step {{ $isDone ? 'done' : '' }} {{ $isCurrent ? 'current' : '' }}">
                <span class="step-icon-s">{{ $icon }}</span>
                <strong>{{ ucwords(str_replace('_',' ',$step)) }}</strong>
            </div>
            @endforeach
        </div>

        <!-- MAP -->
        <div id="map"></div>

        <div style="margin-top:1rem; background:var(--card-bg); padding:1.5rem; border-radius:12px">
            <p><strong>Delivering to:</strong> {{ $order->delivery_address }}</p>
            <p id="statusText"><strong>Status:</strong> {{ ucwords(str_replace('_',' ',$order->status)) }}</p>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const orderId = {{ $order->id }};
const map = L.map('map').setView([23.8103, 90.4125], 14);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
}).addTo(map);

const riderIcon = L.divIcon({className:'', html:'<div style="font-size:2rem">🛵</div>', iconSize:[40,40]});
let riderMarker = L.marker([23.8103, 90.4125], {icon: riderIcon}).addTo(map);

function refreshLocation() {
    fetch(`/orders/${orderId}/location`)
        .then(r => r.json())
        .then(data => {
            riderMarker.setLatLng([data.lat, data.lng]);
            map.setView([data.lat, data.lng], 15);
            document.getElementById('statusText').innerHTML =
                `<strong>Status:</strong> ${data.status.replace(/_/g,' ').replace(/\b\w/g,c=>c.toUpperCase())}`;

            if (data.status === 'delivered') clearInterval(timer);
        });
}

refreshLocation();
const timer = setInterval(refreshLocation, 10000); // poll every 10s
</script>
@endpush
