<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CCTV Monitoring</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('images/logo-kominfo.png') }}" type="image/x-icon">

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
    </style>
</head>

<body class="bg-dark hold-transition sidebar-mini">
    <div class="wrapper">
        <div class="bg-dark">

            <div class="bg-gradient-dark shadow-lg mb-4">
                <div class="container-fluid d-flex justify-content-between align-items-center">
                    <!-- Logo -->
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('images/rb_3083.png') }}" alt="Logo" height="150" class="mr-3">
                        <span class="text-white font-weight-bold h3">CCTV Monitoring <br> Diskominfo Kabupaten Malang</span>
                    </div>

                    <!-- Tombol Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </button>
                    </form>
                </div>
                <div class="container-fluid">
                    <div class="row text-center">
                        <div class="col">
                            @can('view_cctv')
                            <a href="{{ route('cctv.index') }}" class="text-decoration-none d-block">
                                <div class="nav-item p-3 {{ request()->routeIs('cctv.index') ? 'active-tab' : '' }}">
                                    <i class="fas fa-video fa-lg mb-2 {{ request()->routeIs('cctv.index') ? 'text-primary' : 'text-muted' }}"></i>
                                    <h6 class="mb-0 fw-semibold {{ request()->routeIs('cctv.index') ? 'text-white' : 'text-muted' }}">Live View</h6>
                                </div>
                            </a>
                            @endcan
                        </div>

                        <div class="col">
                            @can('playback_cctv')
                            <a href="{{ route('playback') }}" class="text-decoration-none d-block">
                                <div class="nav-item p-3 {{ request()->routeIs('playback') ? 'active-tab' : '' }}">
                                    <i class="fas fa-film fa-lg mb-2 {{ request()->routeIs('playback') ? 'text-primary' : 'text-muted' }}"></i>
                                    <h6 class="mb-0 fw-semibold {{ request()->routeIs('playback') ? 'text-white' : 'text-muted' }}">Playback</h6>
                                </div>
                            </a>
                            @endcan
                        </div>

                        <div class="col">
                            @can('manage_settings')
                            <a href="{{ route('settings') }}" class="text-decoration-none d-block">
                                <div class="nav-item p-3 {{ request()->routeIs('settings') ? 'active-tab' : '' }}">
                                    <i class="fas fa-cog fa-lg mb-2 {{ request()->routeIs('settings') ? 'text-primary' : 'text-muted' }}"></i>
                                    <h6 class="mb-0 fw-semibold {{ request()->routeIs('settings') ? 'text-white' : 'text-muted' }}">Settings</h6>
                                </div>
                            </a>
                            @endcan
                        </div>

                        <div class="col">
                            @can('view_logs')
                            <a href="{{ route('logs') }}" class="text-decoration-none d-block">
                                <div class="nav-item p-3 {{ request()->routeIs('logs') ? 'active-tab' : '' }}">
                                    <i class="fas fa-clipboard-list fa-lg mb-2 {{ request()->routeIs('logs') ? 'text-primary' : 'text-muted' }}"></i>
                                    <h6 class="mb-0 fw-semibold {{ request()->routeIs('logs') ? 'text-white' : 'text-muted' }}">Logs</h6>
                                </div>
                            </a>
                            @endcan
                        </div>

                        <div class="col">
                            @can('manage_users')
                            <a href="{{ route('users') }}" class="text-decoration-none d-block">
                                <div class="nav-item p-3 {{ request()->routeIs('users') ? 'active-tab' : '' }}">
                                    <i class="fas fa-users fa-lg mb-2 {{ request()->routeIs('users') ? 'text-primary' : 'text-muted' }}"></i>
                                    <h6 class="mb-0 fw-semibold {{ request()->routeIs('users') ? 'text-white' : 'text-muted' }}">Users</h6>
                                </div>
                            </a>
                            @endcan
                        </div>
                    </div>

                    <div class="col">
                            @can('manage_accounts')
                            <a href="{{ route('cctv.accounts') }}" class="text-decoration-none d-block">
                                <div class="nav-item p-3 {{ request()->routeIs('cctv.accounts') ? 'active-tab' : '' }}">
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

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE -->
        <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>


</body>

</html>