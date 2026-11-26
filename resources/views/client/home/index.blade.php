@extends('layouts.client')
@section('title', 'Home')

@section('content')
<!-- HERO -->
<section class="hero">
    <div class="hero-content">
        <div class="hero-badge">🔥 Free delivery on first order</div>
        <h1 class="hero-title">Food that<br><em>hits different.</em></h1>
        <p class="hero-sub">Order from the best local restaurants. Delivered hot to your door in 30 minutes.</p>
        <div class="hero-actions">
            <a href="{{ route('menu') }}" class="btn-primary btn-lg">Order Now →</a>
            <div class="hero-stat">
                <span class="stat-num">500+</span>
                <span class="stat-label">Menu Items</span>
            </div>
        </div>
    </div>
    <div class="hero-visual">
        <div class="hero-bowl">🍜</div>
        <div class="hero-float hero-float-1">🍔</div>
        <div class="hero-float hero-float-2">🍕</div>
        <div class="hero-float hero-float-3">🍣</div>
        <div class="hero-float hero-float-4">🥤</div>
    </div>
</section>

<!-- CATEGORIES -->
<section class="section">
    <div class="container">
        <h2 class="section-title">Browse by <em>Category</em></h2>
        <div class="categories-grid">
            @foreach($categories as $cat)
            <a href="{{ route('menu', ['category' => $cat->id]) }}" class="category-card">
                <span class="cat-icon">{{ $cat->icon }}</span>
                <span class="cat-name">{{ $cat->name }}</span>
                <span class="cat-count">{{ $cat->products_count }} items</span>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- FEATURED ITEMS -->
<section class="section section-dark">
    <div class="container">
        <h2 class="section-title">Featured <em>Today</em></h2>
        <div class="products-grid">
            @foreach($featured as $product)
            <div class="product-card">
                <div class="product-image">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" onerror="this.src='https://via.placeholder.com/300x200/e4002b/ffffff?text=🍽️'">
                    @if(!$product->is_available)
                        <div class="product-unavailable">Unavailable</div>
                    @endif
                </div>
                <div class="product-info">
                    <div class="product-category">{{ $product->category->name }}</div>
                    <h3 class="product-name">{{ $product->name }}</h3>
                    <p class="product-desc">{{ Str::limit($product->description, 60) }}</p>
                    <div class="product-footer">
                        <span class="product-price">৳{{ number_format($product->price, 0) }}</span>
                        @if($product->is_available)
                        <button class="btn-add-cart" data-id="{{ $product->id }}" data-name="{{ $product->name }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Add
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="section-cta">
            <a href="{{ route('menu') }}" class="btn-outline">View Full Menu →</a>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="section">
    <div class="container">
        <h2 class="section-title">How it <em>Works</em></h2>
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-num">01</div>
                <div class="step-icon">🛍️</div>
                <h3>Choose Your Food</h3>
                <p>Browse our menu and pick your favorites</p>
            </div>
            <div class="step-card">
                <div class="step-num">02</div>
                <div class="step-icon">💳</div>
                <h3>Quick Checkout</h3>
                <p>Pay securely via card, bKash or cash</p>
            </div>
            <div class="step-card">
                <div class="step-num">03</div>
                <div class="step-icon">🛵</div>
                <h3>Track in Real-Time</h3>
                <p>Watch your order move on live map</p>
            </div>
            <div class="step-card">
                <div class="step-num">04</div>
                <div class="step-icon">🎉</div>
                <h3>Enjoy!</h3>
                <p>Hot food delivered to your door</p>
            </div>
        </div>
    </div>
</section>
@endsection
