<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('') }}">
    <title>@yield('title', 'FooDash') — Fast & Fresh Delivery</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/client.css') }}">
    @stack('styles')
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="nav-container">
        <a href="{{ route('home') }}" class="nav-logo">
            <span class="logo-icon">🍜</span>
            <span class="logo-text">Foo<em>Dash</em></span>
        </a>
        <ul class="nav-links">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ route('menu') }}" class="{{ request()->routeIs('menu') ? 'active' : '' }}">Menu</a></li>
            <li><a href="{{ route('orders.history') }}">My Orders</a></li>
        </ul>
        <div class="nav-actions">
            <a href="{{ route('cart') }}" class="cart-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                <span class="cart-count" id="cartCount">{{ count(session('cart', [])) }}</span>
            </a>
            <div class="user-menu">
                <button class="user-btn">
                    <span>{{ Auth::user()->name }}</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="user-dropdown">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- FLASH MESSAGES -->
@if(session('success'))
<div class="flash flash-success">{{ session('success') }}</div>
@endif
@if($errors->any())
<div class="flash flash-error">{{ $errors->first() }}</div>
@endif

<!-- MAIN CONTENT -->
<main>
    @yield('content')
</main>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer-inner">
        <div class="footer-brand">
            <span class="logo-icon">🍜</span>
            <span class="logo-text">Foo<em>Dash</em></span>
            <p>Hot food, fast delivery.</p>
        </div>
        <div class="footer-links">
            <h4>Quick Links</h4>
            <a href="{{ route('menu') }}">Browse Menu</a>
            <a href="{{ route('orders.history') }}">Order History</a>
        </div>
    </div>
    <div class="footer-bottom">© {{ date('Y') }} FooDash. All rights reserved.</div>
</footer>

<script src="{{ asset('js/client.js') }}"></script>
@stack('scripts')
</body>
</html>
