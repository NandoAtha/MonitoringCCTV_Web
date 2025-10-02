<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring CCTV Diskominfo Kabupaten Malang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('images/logo-kominfo.png') }}" type="image/x-icon">
    
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>

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
        
        /* CSS untuk tampilan Live Stream */
        .video-container {
            aspect-ratio: 16 / 9;
            background: var(--dark-bg);
            position: relative;
            overflow: hidden;
            border: 1px solid var(--muted-text);
            border-radius: 5px;
        }
        
        /* Style untuk video player agar mengisi container */
        .video-container video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .video-overlay {
            background: rgba(0,0,0,0.8);
            backdrop-filter: blur(5px);
            z-index: 10;
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
        
        /* ... CSS lainnya ... */
        
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
        
        /* CSS untuk Accordion Kustom */
        .accordion-wrapper .card {
            background-color: var(--dark-bg);
            border: none;
            border-bottom: 1px solid #495057;
            border-radius: 0;
        }

        .accordion-wrapper .card:last-child {
             border-bottom: none;
        }

        .accordion-wrapper .card-header {
            padding: 0;
            background-color: transparent;
            border-bottom: none;
        }

        .accordion-button {
            width: 100%;
            text-align: left;
            padding: 1rem 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--light-text);
            background-color: transparent;
            border: none;
            transition: background-color 0.3s;
            border: 1px solid transparent;
        }

        .accordion-button.active, .accordion-button:hover, .accordion-button:focus {
            background-color: var(--dark-card-bg);
            text-decoration: none;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
            border-radius: .25rem;
        }
        
        /* Override untuk tampilan yang benar-benar aktif/terbuka */
        .accordion-wrapper .card:first-child .accordion-button.active {
            border-bottom: none;
            border-radius: .25rem .25rem 0 0;
        }

        .accordion-button .fa-chevron-down {
            transition: transform 0.3s;
        }

        .accordion-button.collapsed .fa-chevron-down {
            transform: rotate(0deg);
        }
        
        .accordion-button:not(.collapsed) .fa-chevron-down {
            transform: rotate(180deg);
        }

        .accordion-wrapper .card-body {
            background-color: var(--dark-card-bg);
            padding: 1.5rem;
            border-radius: 0 0 .25rem .25rem;
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

    ---
    
    {{-- START: Daftar Lokasi CCTV --}}
    <div class="container my-5">
        <h2 class="text-center mb-5 text-white">Live View Lokasi CCTV</h2>
        
        <div id="cctv-accordion" class="accordion-wrapper">
            
            {{-- HAPUS DATA DUMMY ($cctvLocations) dan gunakan data $cameras dari PublicController --}}

            @foreach($cameras as $locationName => $camerasInLocation)
            <div class="card">
                <div class="card-header" id="heading-{{ \Illuminate\Support\Str::slug($locationName) }}">
                    <button class="accordion-button @if(!$loop->first) collapsed @else active @endif" data-toggle="collapse" data-target="#collapse-{{ \Illuminate\Support\Str::slug($locationName) }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapse-{{ \Illuminate\Support\Str::slug($locationName) }}">
                        {{ $locationName }}
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>

                <div id="collapse-{{ \Illuminate\Support\Str::slug($locationName) }}" class="collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading-{{ \Illuminate\Support\Str::slug($locationName) }}" data-parent="#cctv-accordion">
                    <div class="card-body">
                        <div class="row">
                            @foreach($camerasInLocation as $camera)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="video-container shadow-lg">
                                    
                                    {{-- LOGIKA TAMPILAN VIDEO LIVE/OFFLINE --}}
                                    @if($camera['online'])
                                        {{-- Video Tag dengan ID unik untuk HLS.js --}}
                                        <video id="video-{{ \Illuminate\Support\Str::slug($camera['name']) }}" controls muted autoplay playsinline>
                                            <p>Browser Anda tidak mendukung tag video.</p>
                                        </video>
                                        
                                        <div class="position-absolute top-0 start-0 m-2" style="z-index: 20;">
                                            <span class="badge badge-success">LIVE</span>
                                        </div>
                                        
                                        {{-- SCRIPT HLS.JS UNTUK SETIAP VIDEO --}}
                                        <script>
                                            var videoId = "video-{{ \Illuminate\Support\Str::slug($camera['name']) }}";
                                            var video = document.getElementById(videoId);
                                            // Ambil URL HLS dari data controller
                                            var hlsUrl = '{{ $camera["stream_url"] }}'; 

                                            if (Hls.isSupported()) {
                                                var hls = new Hls();
                                                hls.loadSource(hlsUrl);
                                                hls.attachMedia(video);
                                                hls.on(Hls.Events.MANIFEST_PARSED, function () {
                                                    // Coba putar otomatis
                                                    video.play().catch(e => console.log('Autoplay diblokir atau gagal:', e));
                                                });
                                            } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                                                // Dukungan native HLS untuk Safari
                                                video.src = hlsUrl;
                                                video.addEventListener('loadedmetadata', function () {
                                                    video.play();
                                                });
                                            } else {
                                                console.error("Browser tidak mendukung HLS!");
                                            }
                                        </script>
                                        
                                    @else
                                        {{-- TAMPILAN OFFLINE --}}
                                        <div class="video-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center">
                                            <i class="fas fa-video-slash fa-4x text-danger mb-3"></i>
                                            <h6 class="text-white">Kamera Offline / Tidak Tersedia</h6>
                                            {{-- Tampilkan placeholder jika ada --}}
                                            @if($camera['image_placeholder'])
                                                <div class="position-absolute top-0 start-0 w-100 h-100" style="background-image: url('{{ $camera['image_placeholder'] }}'); background-size: cover; background-position: center; opacity: 0.2;"></div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <p class="text-center text-muted mt-2 mb-0" style="font-size: 0.9rem;">
                                    {{ $camera['name'] }}
                                </p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
    {{-- END: Daftar Lokasi CCTV --}}

    ---

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
    <script>
        // JS untuk memastikan tombol accordion berubah statusnya
        $('.accordion-button').on('click', function() {
            var target = $(this).data('target');
            // Hapus kelas 'active' dari semua tombol
            $('.accordion-button').removeClass('active');
            // Tambahkan kelas 'active' ke tombol yang sedang diklik (atau ditargetkan)
            if ($(target).hasClass('show')) {
                $(this).removeClass('active');
            } else {
                 $(this).addClass('active');
            }
        });
        
        // Atur status aktif pada load awal (jika ada yang 'show')
        $(document).ready(function() {
            $('.collapse.show').each(function() {
                var id = $(this).attr('id');
                $(`[data-target="#${id}"]`).addClass('active');
            });
        });
    </script>

</body>

</html>