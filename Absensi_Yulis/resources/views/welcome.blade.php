<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Absensi</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Styles -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(to bottom, #ff2d20, #ffffff);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .login-container .logo img {
            height: 80px;
            margin-bottom: 20px;
        }
        .login-container h2 {
            margin-bottom: 20px;
            color: #333333;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333333;
        }
        .form-group input {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            margin: 0 auto;
            display: block;
        }
        .form-group input:focus {
            border-color: #ff2d20;
        }
        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .remember-me input {
            margin-right: 10px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #ff2d20;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
            margin-top: 10px;
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background: #e60000;
        }
        .links {
            margin-top: 10px;
        }
        .links a {
            display: inline-block;
            margin: 5px;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s;
        }
        .links a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <img src="{{ asset('images/LogoYulis.jpg') }}" alt="Logo">
        </div>
        <h2>Yulis baby shop</h2>
        
        <!-- Form Login Shared -->
        <form method="POST" id="loginForm">
            @csrf
            <div class="form-group">
                <label for="id_user">Username</label>
                <input id="id_user" type="text" name="id_user" required autofocus autocomplete="id_user">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password">
            </div>
            <div class="remember-me">
                <input id="remember_me" type="checkbox" name="remember">
                <label for="remember_me">Remember me</label>
            </div>
            <div>
                <button type="button" class="btn" onclick="submitForm()">Log in</button>
            </div>
        </form>

        <div class="links">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Forgot your password?</a>
            @endif
             <!--  @if (Route::has('register'))
                <a href="{{ route('register') }}">Register</a>
            @endif-->
        </div>
    </div>

    <!-- JavaScript for form submission -->
    <script>
        function submitForm() {
            const form = document.getElementById('loginForm');
            const idUser = document.getElementById('id_user').value.trim();

            // Send AJAX request to backend to check role
            fetch('{{ route('check.role') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ username: idUser })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.role === 'admin') {
                    form.action = '{{ route('login') }}';
                } else if (data.role === 'owner') {
                    form.action = '{{ route('owner.login') }}';
                } else {
                    alert('Invalid user ID');
                    return;
                }
                form.method = 'POST';
                form.submit();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to check role');
            });
        }
    </script>
</body>
</html>
