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
</head>
<body class="bg-dark hold-transition sidebar-mini" >
<div class="wrapper">
<div class="bg-dark">

<div class="bg-gradient-dark shadow-lg mb-4">
    <div class="container-fluid py-2 d-flex justify-content-end">
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
                        <div class="nav-item active p-3 position-relative">
                            <i class="fas fa-video fa-lg mb-2 text-primary"></i>
                            <h6 class="mb-0 fw-semibold text-white">Live View</h6>
                            <div class="active-indicator"></div>
                        </div>
                    </a>
                @endcan
            </div>

            <div class="col">
                @can('playback_cctv')
                    <a href="{{ route('playback') }}" class="text-decoration-none d-block">
                        <div class="nav-item p-3">
                            <i class="fas fa-film fa-lg mb-2 text-muted"></i>
                            <h6 class="mb-0 text-muted">Playback</h6>
                        </div>
                    </a>
                @endcan
            </div>

            <div class="col">
                @can('manage_settings')
                    <a href="{{ route('settings') }}" class="text-decoration-none d-block">
                        <div class="nav-item p-3">
                            <i class="fas fa-cog fa-lg mb-2 text-muted"></i>
                            <h6 class="mb-0 text-muted">Settings</h6>
                        </div>
                    </a>
                @endcan
            </div>

            <div class="col">
                @can('view_logs')
                    <a href="{{ route('logs') }}" class="text-decoration-none d-block">
                        <div class="nav-item p-3">
                            <i class="fas fa-clipboard-list fa-lg mb-2 text-muted"></i>
                            <h6 class="mb-0 text-muted">Logs</h6>
                        </div>
                    </a>
                @endcan
            </div>

            <div class="col">
                @can('manage_users')
                    <a href="{{ route('users') }}" class="text-decoration-none d-block">
                        <div class="nav-item p-3">
                            <i class="fas fa-users fa-lg mb-2 text-muted"></i>
                            <h6 class="mb-0 text-muted">Users</h6>
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
