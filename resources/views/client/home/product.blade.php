@extends('layouts.client')
@section('title', $product->name)

@section('content')
<div class="page-header">
    <div class="container">
        <a href="{{ route('menu') }}" style="color:var(--text-muted);text-decoration:none;font-size:.9rem">← Back to Menu</a>
    </div>
</div>

<section class="section">
    <div class="container">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:3rem;align-items:start">
            <!-- IMAGE -->
            <div style="border-radius:24px;overflow:hidden;aspect-ratio:4/3;background:#111">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                     style="width:100%;height:100%;object-fit:cover"
                     onerror="this.src='https://via.placeholder.com/600x450/e4002b/ffffff?text={{ urlencode($product->name) }}'">
            </div>

            <!-- INFO -->
            <div>
                <div style="font-size:.8rem;color:var(--primary);font-weight:700;text-transform:uppercase;letter-spacing:.1em;margin-bottom:.5rem">
                    {{ $product->category->name }}
                </div>
                <h1 style="font-size:2.5rem;margin-bottom:1rem">{{ $product->name }}</h1>
                <p style="color:var(--text-secondary);line-height:1.8;margin-bottom:2rem">
                    {{ $product->description ?? 'A delicious dish prepared fresh for you.' }}
                </p>

                <div style="font-size:2rem;font-weight:900;color:var(--primary);margin-bottom:2rem">
                    ৳{{ number_format($product->price, 0) }}
                </div>

                @if($product->is_available)
                <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem">
                    <div style="display:flex;align-items:center;gap:.5rem;background:var(--card-bg);border:1px solid var(--border);border-radius:50px;padding:.3rem">
                        <button onclick="changeQty(-1)" style="width:36px;height:36px;border-radius:50%;border:none;background:var(--bg);color:var(--text-primary);font-size:1.2rem;cursor:pointer">−</button>
                        <span id="qty" style="font-weight:700;min-width:30px;text-align:center">1</span>
                        <button onclick="changeQty(1)" style="width:36px;height:36px;border-radius:50%;border:none;background:var(--bg);color:var(--text-primary);font-size:1.2rem;cursor:pointer">+</button>
                    </div>
                </div>
                <button class="btn-primary btn-lg" id="addBtn" onclick="addToCart({{ $product->id }}, '{{ $product->name }}')">
                    Add to Cart →
                </button>
                @else
                <div style="background:rgba(228,0,43,.08);border:1px solid rgba(228,0,43,.25);color:#b30024;padding:.75rem 1.2rem;border-radius:12px;display:inline-block">
                    Currently Unavailable
                </div>
                @endif
            </div>
        </div>

        <!-- RELATED -->
        @if($related->count())
        <div style="margin-top:5rem">
            <h2 class="section-title">You might also like</h2>
            <div class="products-grid">
                @foreach($related as $item)
                <div class="product-card">
                    <div class="product-image">
                        <img src="{{ $item->image_url }}" alt="{{ $item->name }}"
                             onerror="this.src='https://via.placeholder.com/300x200/e4002b/fff?text={{ urlencode($item->name) }}'">
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">{{ $item->name }}</h3>
                        <div class="product-footer">
                            <span class="product-price">৳{{ number_format($item->price, 0) }}</span>
                            <a href="{{ route('product.show', $item->id) }}" class="btn-sm">View</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
let qty = 1;
function changeQty(d) {
    qty = Math.max(1, qty + d);
    document.getElementById('qty').textContent = qty;
}
function addToCart(id, name) {
    const btn = document.getElementById('addBtn');
    btn.textContent = 'Adding...';
    btn.disabled = true;
    fetch('/cart/add', {
        method: 'POST',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content},
        body: JSON.stringify({product_id: id, qty: qty})
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.getElementById('cartCount').textContent = data.count;
            btn.textContent = '✓ Added to Cart!';
            btn.style.background = '#10b981';
            setTimeout(() => { btn.textContent = 'Add to Cart →'; btn.style.background = ''; btn.disabled = false; }, 2000);
        }
    });
}
</script>
@endpush
