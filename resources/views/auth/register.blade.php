<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
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
            align-items: flex-start;
            padding: 60px 40px 80px;
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

        .image-left {
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

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .form-footer a {
            color: black;
            font-size: 14px;
            text-decoration: underline;
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

        .login-link {
            text-align: center;
            width: 100%;
        }

        .login-link a {
            color: #843902;
            font-size: 14px;
            text-decoration: none;
            transition: color 0.3s;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 992px) {
            .form-container {
                flex-direction: column;
                width: 90%;
            }

            .image-left {
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
            <!-- Image on the left -->
            <img src="/images/peri_etreese.jpg" class="image-left" />

            <!-- Form content on the right -->
            <div class="form-content">
                <div class="form-title">Welcome, new user!</div>
                <form method="POST" action="{{ route('register') }}" class="form-box">
                    @csrf

                    {{-- Name --}}
                    <div class="form-group">
                        <label for="name">Name</label>
                        <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus
                            autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <label for="email">Email</label>
                        <x-text-input id="email" type="email" name="email" :value="old('email')" required
                            autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    {{-- Password --}}
                    <div class="form-group">
                        <label for="password">Password</label>
                        <x-text-input id="password" type="password" name="password" required
                            autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    {{-- Confirm Password --}}
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <x-text-input id="password_confirmation" type="password" name="password_confirmation" required
                            autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="login-link">
                        <button type="submit" class="submit-button">Register</button>
                        <a href="{{ route('login') }}">Already have an account? Click here!</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    @include('layouts.footer')
</body>

</html>