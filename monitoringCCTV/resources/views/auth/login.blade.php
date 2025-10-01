<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/logo-kominfo.png') }}" type="image/x-icon">
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72, #2a5298, #3b3b3b); /* gradasi biru ke abu */
        }
        .card {
            border-radius: 15px;
            background-color: #f8f9fa; /* card terang */
            color: #212529;
        }
        .logo {
            width: 100px;
            margin-bottom: 15px;
        }
        .form-control {
            background-color: #ffffff;
            border: 1px solid #ced4da;
            color: #212529;
        }
        .form-control:focus {
            background-color: #ffffff;
            color: #212529;
            box-shadow: 0 0 6px rgba(0,123,255,0.6);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .alert-danger {
            background-color: #dc3545;
            color: #fff;
            border: none;
        }
        .footer-text {
            margin-top: 15px;
            font-size: 0.9rem;
            color: grey;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
    <div class="card shadow p-4 text-center" style="width: 400px;">
        <!-- Logo -->
        <img src="{{ asset('images/rb_3083.png') }}" alt="Logo" class="logo mx-auto d-block">

        <!-- Judul -->
            <!-- Judul -->
    <h3 class="mb-3">Login</h3>

    <!-- Form -->
    <form method="POST" action="/login" id="login-form">
        @csrf
        <div class="mb-3 text-start">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required autofocus>
        </div>
        <div class="mb-3 text-start">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        @if($errors->any())
            <div class="alert alert-danger text-start">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Tombol Login -->
        <button type="button" id="loginBtn" class="btn btn-primary w-100">Login</button>

        <!-- Tempat render captcha (explicit) -->
        <div id="captcha-container"></div>
    </form>

    <!-- reCAPTCHA explicit render -->
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>

    <script>
        var captchaWidget;
        function onloadCallback() {
            // fungsi ini dipanggil setelah API reCAPTCHA siap
        }

        document.getElementById('loginBtn').addEventListener('click', function() {
            if (!captchaWidget) {
                captchaWidget = grecaptcha.render('captcha-container', {
                    'sitekey': '{{ env('NOCAPTCHA_SITEKEY') }}',
                    'callback': function(response) {
                        if(response) {
                            document.getElementById("login-form").submit();
                        }
                    }
                });
            }
            document.getElementById('captcha-container').style.display = 'block';
        });
    </script>

    <!-- Footer kecil -->
    <div class="footer-text">
        © Diskominfo Kabupaten Malang 2025
    </div>
</div>

</body>
</html>
