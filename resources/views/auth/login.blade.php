<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            height: 100%;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #843902;
            overflow-x: hidden;
        }

        .content-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 60px 40px;
            flex-grow: 1;
        }

        .form-container {
            width: 1200px;
            max-width: 100%;
            background: #FFFBEF;
            border-radius: 10px;
            display: flex;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .image-right {
            width: 50%;
            height: auto;
            object-fit: cover;
            display: block;
        }

        .form-content {
            width: 55%;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-title {
            font-size: 36px;
            font-weight: 300;
            color: black;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-box {
            background: #EBC4AE;
            border-radius: 10px;
            padding: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            font-size: 18px;
            font-weight: 300;
            color: black;
            display: block;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            height: 50px;
            border: 1px solid #ddd;
            background: white;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 6px;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            border-color: #843902;
            outline: none;
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 15px;
        }

        .forgot-password a {
            color: #843902;
            font-size: 14px;
            text-decoration: none;
            transition: color 0.3s;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .remember-me input {
            width: 18px;
            height: 18px;
            margin-right: 10px;
            accent-color: #843902;
        }

        .remember-me span {
            font-size: 16px;
            color: #555;
        }

        .submit-button {
            background: #843902;
            color: white;
            font-weight: bold;
            border-radius: 6px;
            padding: 12px 30px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background 0.3s;
            margin-bottom: 15px;
        }

        .submit-button:hover {
            background: #6a2e02;
        }

        .register-link {
            text-align: center;
            width: 100%;
        }

        .register-link a {
            color: #843902;
            font-size: 14px;
            text-decoration: none;
            transition: color 0.3s;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 992px) {
            .form-container {
                flex-direction: column;
                width: 90%;
            }

            .image-right {
                width: 100%;
                height: 250px;
            }

            .form-content {
                width: 100%;
                padding: 40px;
            }

            .form-box {
                max-width: 100%;
            }
        }

        @media (max-width: 576px) {
            .content-wrapper {
                padding: 30px 20px;
            }

            .form-content {
                padding: 30px;
            }

            .form-title {
                font-size: 28px;
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>
    @include ('layouts.navigation')
    <!-- Content -->
    <div class="content-wrapper">
        <div class="form-container">
            <!-- Form content centered -->
            <div class="form-content">
                <div class="form-title">Selamat datang kembali!</div>
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <form method="POST" action="{{ route('login') }}" class="form-box">
                    @csrf

                    <!-- Email Address -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            autocomplete="username">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Forgot Password Link -->
                    <div class="forgot-password">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">Lupa password?</a>
                        @endif
                    </div>

                    <!-- Remember Me -->
                    <div class="remember-me">
                        <input id="remember_me" type="checkbox" name="remember">
                        <span>Ingat saya</span>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="submit-button">Masuk</button>

                    <!-- Don't have an account link -->
                    <div class="register-link">
                        <a href="{{ route('register') }}">Tidak mempunyai akun? Klik disini!</a>
                    </div>
                </form>
            </div>

            <!-- Image on the right -->
            <img src="/images/peri_anggrek.jpg" class="image-right" />
        </div>
    </div>
    </div>
    @include('layouts.footer')
</body>

</html>