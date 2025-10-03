<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CCTV Monitoring @yield('title')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('images/Logo_Kabupaten_Malang.svg') }}" type="image/x-icon">

    <style>
        .active-tab {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            position: relative;
        }

        .active-tab::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 25%;
            width: 50%;
            height: 3px;
            background-color: #007bff;
            border-radius: 2px;
        }

        /* --- PERBAIKAN HOVER START --- */
        /* Menambahkan transisi ke nav-item untuk efek halus */
        .nav-item {
            transition: background-color 0.2s, color 0.2s;
            border-radius: 10px;
        }
        
        /* Gaya hover untuk tab yang TIDAK aktif */
        .nav-item:not(.active-tab):hover {
            background-color: rgba(255, 255, 255, 0.05); /* Latar belakang hover yang sangat subtle */
        }

        /* Mengubah warna ikon dan teks yang 'muted' menjadi putih/terang saat hover */
        .nav-item:not(.active-tab):hover i.text-muted,
        .nav-item:not(.active-tab):hover h6.text-muted {
            color: #f8f9fa !important; /* Warna putih */
        }
        /* --- PERBAIKAN HOVER END --- */

        /* Kelas kustom untuk responsivitas */
        .header-logo {
            max-height: 150px;
        }

        /* Navigasi Tabs: Memastikan tab berderet dan otomatis jika ada penambahan */
        .nav-tabs-row {
            display: flex;
            justify-content: space-around;
            margin: 0 -5px;
        }

        .nav-tabs-row .nav-tab-col {
            padding: 0 5px;
            flex-grow: 1;
        }

        /* Media Query untuk Mobile */
        @media (max-width: 767.98px) {
            .header-logo {
                height: 40px !important;
                max-height: 40px !important;
            }

            .header-title-text {
                font-size: 0.8rem !important;
                line-height: 1.2;
            }

            .logout-text {
                display: none;
            }

            .header-top-bar {
                flex-wrap: wrap;
                padding-top: 10px;
                padding-bottom: 10px;
            }

            .header-title-text br {
                display: none;
            }

            .nav-tabs-row {
                overflow-x: auto;
                flex-wrap: nowrap;
                justify-content: flex-start;
            }

            .nav-tabs-row .nav-tab-col {
                min-width: 80px;
                flex-shrink: 0;
            }

            .nav-item {
                padding: 8px 3px !important;
            }

            .nav-item h6 {
                font-size: 0.6rem !important;
                line-height: 1;
            }

            .nav-item i {
                font-size: 0.8rem !important;
            }
        }
    </style>
</head>

<body class="bg-dark hold-transition sidebar-mini">
    <div class="wrapper">
        <div class="bg-dark">

            <div class="bg-gradient-dark shadow-lg mb-4">
                <div class="container-fluid d-flex justify-content-between align-items-center header-top-bar">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('images/rb_3083.png') }}" alt="Logo" height="150" class="mr-3 header-logo">
                        <span class="text-white font-weight-bold h4 header-title-text">
                            CCTV Monitoring <br> Dinas Komunikasi dan Informatika Kabupaten Malang
                        </span>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="flex-shrink-0">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-sign-out-alt me-1"></i> <span class="logout-text d-none d-sm-inline">Logout</span>
                        </button>
                    </form>
                </div>

                <div class="container-fluid">
                    <div class="nav-tabs-row text-center">

                        <div class="nav-tab-col">
                            @can('view_cctv')
                            <a href="{{ route('cctv.index') }}" class="text-decoration-none d-block">
                                <div class="nav-item p-3 {{ request()->routeIs('cctv.index') ? 'active-tab' : '' }} d-flex flex-column align-items-center">
                                    <i class="fas fa-video fa-lg mb-2 {{ request()->routeIs('cctv.index') ? 'text-primary' : 'text-muted' }}"></i>
                                    <h6 class="mb-0 fw-semibold {{ request()->routeIs('cctv.index') ? 'text-white' : 'text-muted' }}">Live View</h6>
                                </div>
                            </a>
                            @endcan
                        </div>

                        <div class="nav-tab-col">
                            @can('playback_cctv')
                            <a href="{{ route('playback') }}" class="text-decoration-none d-block">
                                <div class="nav-item p-3 {{ request()->routeIs('playback') ? 'active-tab' : '' }} d-flex flex-column align-items-center">
                                    <i class="fas fa-film fa-lg mb-2 {{ request()->routeIs('playback') ? 'text-primary' : 'text-muted' }}"></i>
                                    <h6 class="mb-0 fw-semibold {{ request()->routeIs('playback') ? 'text-white' : 'text-muted' }}">Playback</h6>
                                </div>
                            </a>
                            @endcan
                        </div>

                        <div class="nav-tab-col">
                            @can('manage_settings')
                            <a href="{{ route('settings') }}" class="text-decoration-none d-block">
                                <div class="nav-item p-3 {{ request()->routeIs('settings') ? 'active-tab' : '' }} d-flex flex-column align-items-center">
                                    <i class="fas fa-cog fa-lg mb-2 {{ request()->routeIs('settings') ? 'text-primary' : 'text-muted' }}"></i>
                                    <h6 class="mb-0 fw-semibold {{ request()->routeIs('settings') ? 'text-white' : 'text-muted' }}">Settings</h6>
                                </div>
                            </a>
                            @endcan
                        </div>
                        
                        <!-- <div class="nav-tab-col">
                            @can('view_logs')
                            <a href="{{ route('logs') }}" class="text-decoration-none d-block">
                                <div class="nav-item p-3 {{ request()->routeIs('logs') ? 'active-tab' : '' }} d-flex flex-column align-items-center">
                                    <i class="fas fa-clipboard-list fa-lg mb-2 {{ request()->routeIs('logs') ? 'text-primary' : 'text-muted' }}"></i>
                                    <h6 class="mb-0 fw-semibold {{ request()->routeIs('logs') ? 'text-white' : 'text-muted' }}">Logs</h6>
                                </div>
                            </a>
                            @endcan
                        </div> -->

                        <div class="nav-tab-col">
                            @can('manage_users')
                            <a href="{{ route('users') }}" class="text-decoration-none d-block">
                                <div class="nav-item p-3 {{ request()->routeIs('users') ? 'active-tab' : '' }} d-flex flex-column align-items-center">
                                    <i class="fas fa-users fa-lg mb-2 {{ request()->routeIs('users') ? 'text-primary' : 'text-muted' }}"></i>
                                    <h6 class="mb-0 fw-semibold {{ request()->routeIs('users') ? 'text-white' : 'text-muted' }}">Roles</h6>
                                </div>
                            </a>
                            @endcan
                        </div>
                        
                        <div class="nav-tab-col"> 
                            @can('manage_accounts')
                            <a href="{{ route('cctv.accounts') }}" class="text-decoration-none d-block">
                                <div class="nav-item p-3 {{ request()->routeIs('cctv.accounts') ? 'active-tab' : '' }} d-flex flex-column align-items-center">
                                    <i class="fas fa-users fa-lg mb-2 {{ request()->routeIs('cctv.accounts') ? 'text-primary' : 'text-muted' }}"></i>
                                    <h6 class="mb-0 fw-semibold {{ request()->routeIs('cctv.accounts') ? 'text-white' : 'text-muted' }}">Accounts</h6>
                                </div>
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>

            @yield('content')
            @stack('scripts')

        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

    </div>
</body>

</html>