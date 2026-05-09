@extends('layouts.client')
@section('title', 'Menu')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Our <em>Menu</em></h1>
    </div>
</div>

<section class="section">
    <div class="container">
        <!-- FILTERS -->
        <form class="filter-bar" method="GET" action="{{ route('menu') }}">
            <div class="search-box">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" name="search" placeholder="Search dishes..." value="{{ request('search') }}">
            </div>
            <div class="category-filters">
                <a href="{{ route('menu') }}" class="filter-btn {{ !request('category') ? 'active' : '' }}">All</a>
                @foreach($categories as $cat)
                    <a href="{{ route('menu', ['category' => $cat->id, 'search' => request('search')]) }}"
                       class="filter-btn {{ request('category') == $cat->id ? 'active' : '' }}">
                        {{ $cat->icon }} {{ $cat->name }}
                    </a>
                @endforeach
            </div>
            <button type="submit" class="btn-primary">Search</button>
        </form>

        <!-- PRODUCTS GRID -->
        @if($products->count())
        <div class="products-grid">
            @foreach($products as $product)
            <div class="product-card">
                <div class="product-image">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" onerror="this.src='https://via.placeholder.com/300x200/ff6b35/ffffff?text={{ urlencode($product->name) }}'">
                    @if(!$product->is_available)<div class="product-unavailable">Unavailable</div>@endif
                </div>
                <div class="product-info">
                    <div class="product-category">{{ $product->category->name }}</div>
                    <h3 class="product-name">{{ $product->name }}</h3>
                    <p class="product-desc">{{ Str::limit($product->description, 70) }}</p>
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
        <div class="pagination-wrap">
            {{ $products->links() }}
        </div>
        @else
        <div class="empty-state">
            <div class="empty-icon">🍽️</div>
            <h3>No items found</h3>
            <p>Try a different search or category</p>
        </div>
        @endif
    </div>
</section>
@endsection
