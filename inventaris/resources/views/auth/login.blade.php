<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url('{{ asset('images/backgroundlogin.png') }}') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.37);
            color: #fff;
        }

        .login-card h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            font-weight: bold;
        }

        label {
            color: #fff;
            margin-top: 1rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border-radius: 6px;
            border: none;
            margin-top: 0.25rem;
        }

        .btn-login {
            width: 100%;
            background-color: #e60000;
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 6px;
            font-weight: bold;
            margin-top: 1.5rem;
            transition: 0.3s ease;
        }

        .btn-login:hover {
            background-color: #cc0000;
        }

        .forgot-link {
            display: block;
            margin-top: 0.5rem;
            text-align: right;
            font-size: 0.875rem;
            color: #f0f0f0;
        }

        .forgot-link:hover {
            text-decoration: underline;
            color: #fff;
        }

        .error-message {
            font-size: 0.875rem;
            color: #ffcccc;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h2>Login</h2>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email">Email</label>
                    <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password">Password</label>
                    <input id="password" class="form-control" type="password" name="password" required>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Forgot Password -->
                @if (Route::has('password.request'))
                    <a class="forgot-link" href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
                @endif

                <!-- Submit -->
                <button type="submit" class="btn-login">Login</button>
            </form>
            <div class="text-center" style="font-size: 0.9rem;">
                <span>Belum memiliki akun? </span>
                <a href="{{ route('register') }}" style="color: #fff; font-weight: bold; text-decoration: underline;">
                    Daftar sini!
                </a>
            </div>
        </div>
    </div>
</body>
</html>
