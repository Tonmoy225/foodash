<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — FooDash</title>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@700;900&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body class="auth-body">
<div class="auth-container">
    <div class="auth-visual">
        <div class="auth-visual-content">
            <div class="big-emoji">🚀</div>
            <h2>Join FooDash</h2>
            <p>Create your account<br>and start ordering!</p>
        </div>
    </div>
    <div class="auth-form-side">
        <div class="auth-form-box">
            <h1>Create Account</h1>
            <p class="auth-sub">Fill in the details below</p>

            @if($errors->any())
                <div class="auth-error">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Your Name" required>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+880...">
                    </div>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
                </div>
                <div class="form-group">
                    <label>Delivery Address</label>
                    <textarea name="address" rows="2" placeholder="Your default address">{{ old('address') }}</textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Min 6 chars" required>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" placeholder="Repeat" required>
                    </div>
                </div>
                <button type="submit" class="btn-auth">Create Account</button>
            </form>

            <p class="auth-switch">
                Already have an account? <a href="{{ route('login') }}">Sign in</a>
            </p>
        </div>
    </div>
</div>
</body>
</html>
