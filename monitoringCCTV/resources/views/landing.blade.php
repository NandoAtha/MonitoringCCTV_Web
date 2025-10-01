<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring CCTV Diskominfo Kabupaten Malang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('images/logo-kominfo.png') }}" type="image/x-icon">
    <style>
        :root {
            --primary-color: #0d6efd;
            --dark-bg: #212529;
            --dark-card-bg: #2c3034;
            --light-text: #f8f9fa;
            --muted-text: #adb5bd;
        }

        body {
            background-color: var(--dark-bg);
            color: var(--light-text);
            min-height: 100vh;
        }

        .hero-section {
            padding: 150px 0;
            background: linear-gradient(135deg, rgba(30, 60, 114, 0.85), rgba(42, 82, 152, 0.85)),
            url("{{ asset('images/rb_3083.png') }}");
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
        }

        .card-feature {
            background-color: var(--dark-card-bg);
            border: 1px solid #495057;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card-feature:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
        }

        .social-icons a {
            color: var(--light-text);
            font-size: 1.5rem;
            margin: 0 10px;
            transition: color 0.3s;
        }

        .social-icons a:hover {
            color: var(--primary-color);
        }

        .social-icons .fa-instagram:hover {
            color: #E4405F;
        }

        .social-icons .fa-twitter:hover {
            color: #1DA1F2;
        }

        .social-icons .fa-youtube:hover {
            color: #FF0000;
        }

        .social-icons .fa-facebook-f:hover {
            color: #1877F2;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="justify-content-between flex-grow-1 d-flex align-items-center px-3">
            <a class="navbar-brand font-weight-bold" href="#">
                <img src="{{ asset('images/logo-kominfo.png') }}" alt="Logo" height="40" class="mr-2">
                CCTV MONITORING
            </a>

            <a href="{{ route('login') }}" class="btn btn-primary">
                <i class="fas fa-sign-in-alt mr-1"></i> Masuk ke Platform
            </a>

        </div>
    </nav>

    <div class="hero-section text-center">
        <div class="container">
            <h5 class="text-white mb-2 font-weight-bold">
                DINAS KOMUNIKASI DAN INFORMATIKA KABUPATEN MALANG
            </h5>
            <h1 class="display-4 font-weight-bold mb-3 text-white">
                Platform Monitoring CCTV Digital
            </h1>
            <p class="lead mb-5 text-light">
                Pantau seluruh area vital di Kabupaten Malang secara langsung, kapan saja, dan di mana saja dengan fitur lengkap dan andal.
            </p>
            <a href="{{ route('login') }}" class="btn btn-light btn-lg shadow-lg">
                Mulai Monitoring Sekarang
            </a>
        </div>
    </div>

    <div class="container my-5">
        <h2 class="text-center mb-5 text-white">Kenapa Memilih Platform Ini?</h2>
        <div class="row">

            <div class="col-md-4 mb-4">
                <div class="card card-feature text-center h-100 p-4">
                    <div class="card-body">
                        <i class="fas fa-video fa-3x text-primary mb-3"></i>
                        <h5 class="card-title text-white">Live View Real-time</h5>
                        <p class="card-text text-muted">Akses streaming langsung dari semua kamera Anda dengan latensi rendah dan tampilan grid yang fleksibel (1x1, 2x2, 3x3).</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card card-feature text-center h-100 p-4">
                    <div class="card-body">
                        <i class="fas fa-film fa-3x text-info mb-3"></i>
                        <h5 class="card-title text-white">Playback & Pencarian Cepat</h5>
                        <p class="card-text text-muted">Telusuri rekaman berdasarkan waktu, tanggal, dan jenis rekaman (gerakan, alarm) dengan kontrol pencarian yang mudah.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card card-feature text-center h-100 p-4">
                    <div class="card-body">
                        <i class="fas fa-users-cog fa-3x text-success mb-3"></i>
                        <h5 class="card-title text-white">Manajemen Pengguna Fleksibel</h5>
                        <p class="card-text text-muted">Kelola hak akses pengguna dengan sistem Role & Permission. Tentukan siapa yang bisa melihat, memutar ulang, atau mengatur sistem.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <footer class="bg-dark text-center text-light py-4 border-top border-secondary">
        <div class="container">

            <div class="social-icons mb-3">
                <a href="#" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
                <a href="#" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
            </div>

            <p class="mb-0">Dikelola oleh **Dinas Komunikasi dan Informatika Kabupaten Malang**. &copy; 2025. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>