<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CCTV Online Kabupaten Malang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/Logo_Kabupaten_Malang.svg') }}" type="image/x-icon">

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
            font-family: 'Poppins', sans-serif;
        }

        /* --- TEMA NAV BAR --- */
        .navbar-brand {
            /* Atur font size pada brand jika diperlukan, tapi ini akan diterapkan pada span di HTML */
            font-size: 1.25rem;
            color: var(--primary-color);
        }

        .navbar.transparent {
            background-color: transparent !important;
            transition: background-color 0.4s ease;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030;
            min-height: 75px;
        }

        .navbar.scrolled {
            background-color: var(--dark-bg) !important;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
        }

        /* --- HERO SECTION --- */
        .hero-section {
            min-height: 100vh;
            padding: 100px 0;

            display: flex;
            align-items: center;
            justify-content: center;

            background: url("{{ asset('images/background.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .hero-section>.container {
            position: relative;
            z-index: 2;
        }


        /* CSS untuk tampilan Live Stream */
        .video-container {
            aspect-ratio: 18 / 14;
            background: var(--dark-bg);
            position: relative;
            overflow: hidden;
            border: 1px solid var(--muted-text);
            border-radius: 5px;
            cursor: pointer;
        }

        /* Style untuk video player agar mengisi container */
        .video-container video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .video-overlay {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
            z-index: 10;
        }

        .video-container.paused video {
            display: none;
        }

        .video-container .paused-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--dark-bg);
            color: white;
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-size: 1.2rem;
            cursor: pointer;
            z-index: 15;
        }

        .video-container.paused .paused-overlay {
            display: flex;
        }

        .video-container .paused-overlay i {
            font-size: 3rem;
            margin-bottom: 10px;
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

        .fullscreen-btn {
            position: absolute;
            bottom: 5px;
            right: 5px;
            color: var(--light-text);
            background: rgba(0, 0, 0, 0.5);
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            z-index: 20;
            /* Harus di atas video dan overlay lainnya */
            font-size: 1rem;
            line-height: 1;
            transition: background-color 0.2s;
        }

        .fullscreen-btn:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        /* Sembunyikan tombol saat video ter-pause */
        .video-container.paused .fullscreen-btn {
            display: none;
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

        .social-icons .fa-instagram .fa-twitter .fa-youtube .fa-facebook-f:hover {
            color: #1877F2;
        }

        /* CSS untuk Accordion Kustom */
        .accordion-wrapper .card {
            background-color: var(--dark-bg);
            border: 1px solid #6c757d;
            border-radius: .25rem;
            margin-bottom: 10px;
        }

        .accordion-wrapper .card:last-child {
            border-bottom: 1px solid #6c757d;
        }

        .accordion-wrapper .card-header {
            padding: 0;
            background-color: transparent;
            border-bottom: 1px solid #6c757d;
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
        }

        .accordion-button.active,
        .accordion-button:hover,
        .accordion-button:focus {
            background-color: var(--dark-card-bg);
            text-decoration: none;
            box-shadow: 0 0 0 0.1rem var(--primary-color);
            border: 1px solid var(--primary-color) !important;
            border-radius: .25rem;
        }

        .accordion-wrapper .card:first-child .accordion-button.active {
            border-bottom: 1px solid var(--primary-color) !important;
            border-radius: .25rem .25rem 0 0;
        }

        .accordion-wrapper .card-body {
            background-color: var(--dark-card-bg);
            padding: 1.5rem;
            border-radius: 0 0 .25rem .25rem;
        }

        .accordion-wrapper .card:last-child .card-body {
            border-bottom-left-radius: .25rem;
            border-bottom-right-radius: .25rem;
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

        #contact-info {
            padding: 60px 0;
        }

        .contact-item {
            padding: 15px;
            border-right: 1px solid #3a3f44;
        }

        .contact-item:last-child {
            border-right: none;
        }

        .contact-item i {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .contact-item h5 {
            color: var(--light-text);
            font-weight: 600;
            /* Font Playfair Display Semi-bold */
            margin-bottom: 5px;
        }

        .contact-item p {
            color: var(--muted-text);
            font-size: 0.9rem;
            margin: 0;
            font-weight: 400;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark transparent shadow-sm">
        <div class="justify-content-between flex-grow-1 d-flex align-items-center px-3">
            <a class="navbar-brand font-weight-bold d-flex align-items-center" href="#">
                <img src="{{ asset('images/rb_3083.png') }}" alt="Logo" height="60" class="mr-2">
                <span class="text-left" style="line-height: 1;">
                    Kabupaten<br>Malang
                </span>
            </a>

            <a href="{{ route('login') }}" class="btn btn-primary">
                <i class="fas fa-sign-in-alt mr-1"></i> Login
            </a>

        </div>
    </nav>

    <div class="hero-section text-center">
        <div class="container">
            {{-- **Logo di Hero Section** --}}
            <img src="{{ asset('images/logo-kominfo.png') }}" alt="Logo Kominfo" height="200" class="d-block mx-auto" style="filter: drop-shadow(0 0 10px rgba(0, 0, 0, 0.5));">
            <h1 class="display-4 font-weight-bold mb-2 text-white">
                Akses CCTV Online
            </h1>
            <h5 class="text-white mb-5 font-weight-bold">
                DINAS KOMUNIKASI DAN INFORMATIKA KABUPATEN MALANG
            </h5>

            <a href="#daftar-cctv" class="mt-5 btn btn-lg btn-primary">
                <i class="fas fa-video mr-2"></i> Mulai Pantau Sekarang
            </a>
        </div>
    </div>

    {{-- START: Daftar Lokasi CCTV --}}
    <div id="daftar-cctv" class="container my-5">
        <h2 class="text-center mb-5 text-white">Live View Lokasi CCTV Kabupaten Malang</h2>

        <div id="cctv-accordion" class="accordion-wrapper">

            @foreach($cameras as $locationName => $camerasInLocation)
            <div class="card">
                <div class="card-header" id="heading-{{ \Illuminate\Support\Str::slug($locationName) }}">
                    <button class="accordion-button collapsed" data-toggle="collapse" data-target="#collapse-{{ \Illuminate\Support\Str::slug($locationName) }}" aria-expanded="false" aria-controls="collapse-{{ \Illuminate\Support\Str::slug($locationName) }}">
                        {{ $locationName }}
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>

                <div id="collapse-{{ \Illuminate\Support\Str::slug($locationName) }}" class="collapse" aria-labelledby="heading-{{ \Illuminate\Support\Str::slug($locationName) }}" data-parent="#cctv-accordion">
                    <div class="card-body">
                        <div class="row">
                            @foreach($camerasInLocation as $camera)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="video-container shadow-lg paused">

                                    {{-- LOGIKA TAMPILAN VIDEO LIVE/OFFLINE --}}
                                    @if($camera['online'])
                                    {{-- Video Tag dengan ID unik dan data-hls-url --}}
                                    <video id="video-{{ \Illuminate\Support\Str::slug($camera['name']) }}" muted autoplay playsinline data-hls-url='{{ $camera["stream_url"] }}'>
                                        <p>Browser Anda tidak mendukung tag video.</p>
                                    </video>

                                    <div class="paused-overlay">
                                        <i class="fas fa-play-circle"></i>
                                    </div>

                                    <button class="fullscreen-btn" data-target-video="video-{{ \Illuminate\Support\Str::slug($camera['name']) }}">
                                        <i class="fas fa-expand"></i>
                                    </button>

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
                                <p class="text-center mt-2 mb-0" style="font-size: 0.9rem;">
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

    <section id="contact-info">
        <div class="container">
            <div class="row text-center">

                <div class="col-md-4 contact-item">
                    <i class="fas fa-phone-alt"></i>
                    <h5>Telepon</h5>
                    <p>(0341) 364776</p>
                </div>

                <div class="col-md-4 contact-item">
                    <i class="fas fa-envelope"></i>
                    <h5>Email</h5>
                    <p>kominfo@malangkab.go.id</p>
                </div>

                <div class="col-md-4 contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <h5>Alamat</h5>
                    <p>Jl. K.H. Agus Salim No. 7 Malang 65119</p>
                </div>

            </div>
        </div>
    </section>

    <footer class="bg-dark text-center text-light py-4 border-top border-secondary">
        <div class="container">

            <div class="social-icons mb-3">
                <a href="https://www.instagram.com/kominfokabmlg/" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="https://www.facebook.com/kominfokabmalang" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="https://x.com/kominfokabmlg" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
                <a href="https://www.youtube.com/channel/UCPo6b6DOnJvve7ORpDUbkXA" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
            </div>

            <p class="mb-0">Dinas Komunikasi dan Informatika Kabupaten Malang &copy; 2025</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // **INIT GLOBAL HLS INSTANCE STORE**
        var hlsInstances = {};
        var scrollThreshold = 100; // Jarak scroll (dalam px) sebelum navbar menjadi solid

        $(document).ready(function() {
            // Inisialisasi HLS untuk semua elemen video yang memiliki data-hls-url
            $('video[id^="video-"]').each(function() {
                var videoElement = this;
                var videoId = videoElement.id;
                // Ambil URL HLS dari data-attribute yang sudah kita tambahkan
                var hlsUrl = $(videoElement).attr('data-hls-url');

                if (!hlsUrl) return;

                if (Hls.isSupported()) {
                    var hls = new Hls();
                    hls.loadSource(hlsUrl);
                    hls.attachMedia(videoElement);

                    hlsInstances[videoId] = hls;

                    hls.on(Hls.Events.MANIFEST_PARSED, function() {
                        // Biarkan video ter-pause sesuai default 'paused' class di container
                        videoElement.pause();
                        if (hls.stopLoad) hls.stopLoad(); // Stop load HLS saat startup
                    });
                } else if (videoElement.canPlayType('application/vnd.apple.mpegurl')) {
                    // Dukungan native HLS untuk Safari
                    videoElement.src = hlsUrl;
                    videoElement.pause();
                } else {
                    console.error("Browser tidak mendukung HLS!");
                }
            });

            // 4. Panggil logic scroll saat dokumen dimuat (untuk kasus reload di tengah halaman)
            toggleNavbar();
        });

        $('.accordion-button').on('click', function() {
            var $button = $(this);
            var target = $button.data('target');

            // Hapus kelas 'active' dari semua tombol
            $('.accordion-button').not($button).removeClass('active');

            // Toggle manual class 'active'
            if ($button.hasClass('collapsed')) {
                $button.addClass('active');
            } else {
                $button.removeClass('active');
            }
        });

        $(".video-container").on("click", function() {
            const container = $(this);
            const $video = container.find("video");

            if ($video.length) {
                const videoElement = $video.get(0);
                const videoId = videoElement.id;
                const hlsInstance = hlsInstances[videoId];

                // Toggle pause/play visual & state
                container.toggleClass("paused");

                if (container.hasClass("paused")) {
                    // JIKA PAUSE (Sembunyikan Video)
                    videoElement.pause();

                    // HLS.js: Hentikan pemuatan data
                    if (hlsInstance) {
                        hlsInstance.stopLoad();
                    }

                } else {
                    // JIKA PLAY (Tampilkan Video)

                    // HLS.js: Mulai kembali pemuatan data
                    if (hlsInstance) {
                        hlsInstance.startLoad();
                    }

                    var playPromise = videoElement.play();

                    if (playPromise !== undefined) {
                        playPromise.then(_ => {
                                // Playback dimulai
                            })
                            .catch(error => {
                                // Coba muted play sebagai fallback cepat
                                console.error("Resume play gagal. Coba muted:", error);
                                videoElement.muted = true;
                                videoElement.play().catch(e => console.error("Muted play failed:", e));
                            });
                    }
                }
            }
        });

        $('.fullscreen-btn').on('click', function(e) {
            e.stopPropagation();

            var container = $(this).closest('.video-container').get(0);

            // Cek apakah saat ini sudah dalam mode fullscreen
            if (document.fullscreenElement === container ||
                document.webkitFullscreenElement === container ||
                document.mozFullScreenElement === container ||
                document.msFullscreenElement === container) {
                // KELUAR dari Fullscreen
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
            } else {
                // MASUK ke Fullscreen (pada elemen container)
                if (container.requestFullscreen) {
                    container.requestFullscreen();
                } else if (container.mozRequestFullScreen) {
                    container.mozRequestFullScreen();
                } else if (container.webkitRequestFullscreen) {
                    container.webkitRequestFullscreen();
                } else if (container.msRequestFullscreen) {
                    container.msRequestFullscreen();
                }
            }
        });

        $(document).on('fullscreenchange webkitfullscreenchange mozfullscreenchange msfullscreenchange', function() {
            $('.video-container').each(function() {
                var isFullscreen = document.fullscreenElement === this ||
                    document.webkitFullscreenElement === this ||
                    document.mozFullScreenElement === this ||
                    document.msFullscreenElement === this;

                var $button = $(this).find('.fullscreen-btn i');

                if (isFullscreen) {
                    $button.removeClass('fa-expand').addClass('fa-compress');
                } else {
                    $button.removeClass('fa-compress').addClass('fa-expand');
                }
            });
        });

        function toggleNavbar() {
            var nav = $('.navbar.transparent');
            if ($(window).scrollTop() > scrollThreshold) {
                nav.addClass('scrolled');
            } else {
                nav.removeClass('scrolled');
            }
        }

        // Panggil setiap kali pengguna scroll
        $(window).on('scroll', toggleNavbar);
    </script>

</body>

</html>