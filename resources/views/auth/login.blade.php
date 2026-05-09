<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — FooDash</title>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@700;900&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body class="auth-body">
<div class="auth-container">
    <div class="auth-visual">
        <div class="auth-visual-content">
            <div class="big-emoji">🍜</div>
            <h2>FooDash</h2>
            <p>Hot food. Fast delivery.<br>Every single time.</p>
        </div>
    </div>
    <div class="auth-form-side">
        <div class="auth-form-box">
            <h1>Welcome back</h1>
            <p class="auth-sub">Sign in to your account</p>

            @if($errors->any())
                <div class="auth-error">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                <label class="remember-label">
                    <input type="checkbox" name="remember"> Remember me
                </label>
                <button type="submit" class="btn-auth">Sign In</button>
            </form>

            <p class="auth-switch">
                Don't have an account? <a href="{{ route('register') }}">Register</a>
            </p>

            <div class="auth-demo">
                <p><strong>Demo accounts:</strong></p>
                <p>Client: client@foodash.com / password</p>
                <p>Admin: admin@foodash.com / password</p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
