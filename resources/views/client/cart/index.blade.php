@extends('layouts.client')
@section('title', 'Cart')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Your <em>Cart</em></h1>
    </div>
</div>

<section class="section">
    <div class="container">
        @if(empty($cart))
            <div class="empty-state">
                <div class="empty-icon">🛒</div>
                <h3>Your cart is empty</h3>
                <p>Add some delicious items from our menu</p>
                <a href="{{ route('menu') }}" class="btn-primary">Browse Menu</a>
            </div>
        @else
        <div class="cart-layout">
            <!-- CART ITEMS -->
            <div class="cart-items">
                @foreach($cart as $item)
                <div class="cart-item" id="cart-item-{{ $item['id'] }}">
                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" onerror="this.src='https://via.placeholder.com/80x80/e4002b/fff?text=🍽️'">
                    <div class="cart-item-info">
                        <h4>{{ $item['name'] }}</h4>
                        <span class="item-unit-price">৳{{ number_format($item['price'], 0) }} each</span>
                    </div>
                    <div class="qty-control">
                        <button class="qty-btn" onclick="updateQty({{ $item['id'] }}, -1)">−</button>
                        <span class="qty-value" id="qty-{{ $item['id'] }}">{{ $item['qty'] }}</span>
                        <button class="qty-btn" onclick="updateQty({{ $item['id'] }}, 1)">+</button>
                    </div>
                    <div class="item-total" id="total-{{ $item['id'] }}">৳{{ number_format($item['price'] * $item['qty'], 0) }}</div>
                    <button class="remove-btn" onclick="removeItem({{ $item['id'] }})">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                    </button>
                </div>
                @endforeach
            </div>

            <!-- CART SUMMARY -->
            <div class="cart-summary">
                <h3>Order Summary</h3>

                <!-- VOUCHER -->
                <div class="voucher-box">
                    <label>Have a voucher?</label>
                    <div class="voucher-input-row">
                        <input type="text" id="voucherCode" placeholder="Enter code" value="{{ $voucher['code'] ?? '' }}">
                        <button onclick="applyVoucher()" class="btn-voucher">Apply</button>
                    </div>
                    <div id="voucherMsg"></div>
                </div>

                <div class="summary-rows">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span id="summarySubtotal">৳{{ number_format($subtotal, 0) }}</span>
                    </div>
                    <div class="summary-row" id="discountRow" style="{{ $discount > 0 ? '' : 'display:none' }}">
                        <span>Discount</span>
                        <span class="text-green" id="summaryDiscount">-৳{{ number_format($discount, 0) }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Delivery Fee</span>
                        <span>৳{{ number_format($fee, 0) }}</span>
                    </div>
                    <div class="summary-row total-row">
                        <span>Total</span>
                        <span id="summaryTotal">৳{{ number_format($total, 0) }}</span>
                    </div>
                </div>

                <a href="{{ route('checkout') }}" class="btn-primary btn-full">
                    Proceed to Checkout →
                </a>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
const DELIVERY_FEE = 40;

function updateQty(id, change) {
    const qtyEl = document.getElementById('qty-' + id);
    let qty = parseInt(qtyEl.textContent) + change;
    if (qty < 1) { removeItem(id); return; }

    fetch('/cart/update', {
        method: 'POST',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content},
        body: JSON.stringify({product_id: id, qty})
    }).then(() => location.reload());
}

function removeItem(id) {
    fetch('/cart/remove', {
        method: 'POST',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content},
        body: JSON.stringify({product_id: id})
    }).then(() => location.reload());
}

function applyVoucher() {
    const code = document.getElementById('voucherCode').value;
    fetch('/cart/voucher', {
        method: 'POST',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content},
        body: JSON.stringify({code})
    })
    .then(r => r.json())
    .then(data => {
        const msg = document.getElementById('voucherMsg');
        if (data.success) {
            msg.className = 'voucher-success';
            msg.textContent = data.message;
            location.reload();
        } else {
            msg.className = 'voucher-error';
            msg.textContent = data.message;
        }
    });
}
</script>
@endpush
