@extends('layouts.admin')

@section('title', 'Live CCTV')

@section('content')

<div class="container-fluid">
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="control-panel bg-dark-subtle rounded-3 p-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex align-items-center gap-3">
                        <h5 class="mb-0 fw-bold text-white">
                            <i class="fas fa-video text-primary me-2"></i>
                            Live Monitoring
                        </h5>
                        <div class="device-status" style="margin-left: 5px;">
                            <span class="badge bg-success rounded-pill px-3 py-2">
                                <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                                All Devices: {{ count($cameras) }}
                            </span>
                            <span class="badge bg-primary rounded-pill px-3 py-2 ms-2">
                                <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                                Online: {{ collect($cameras)->where('online', true)->count() }}
                            </span>
                        </div>
                    </div>
                    <div class="control-buttons d-flex align-items-center flex-wrap mt-2 mt-md-0">
                        <div id="camera-select-dropdown" class="me-3" style="display: none;">
                            <select class="form-select form-select-sm bg-dark text-white border-secondary" 
                                    onchange="selectSingleCamera(this.value)">
                                @foreach($cameras as $index => $cam)
                                    <option value="{{ $index }}" class="bg-dark text-white">
                                        {{ $cam['name'] }} @if($cam['online'] ?? false) (Online) @else (Offline) @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn btn-primary btn-sm me-2" onclick="refreshAllStreams()">
                            <i class="fas fa-sync-alt me-1"></i>
                            Refresh All
                        </button>
                        <button class="btn btn-secondary btn-sm me-2" onclick="stopAllStreams()">
                            <i class="fas fa-stop me-1"></i>
                            Stop All
                        </button>
                        <div class="btn-group" role="group">
                            <button class="btn btn-primary btn-sm" onclick="changeLayout(event, 1)">
                                <i class="fas fa-square"></i>
                            </button>
                            <button class="btn btn-outline-light btn-sm" onclick="changeLayout(event, 4)">
                                <i class="fas fa-th-large"></i>
                            </button>
                            <button class="btn btn-outline-light btn-sm" onclick="changeLayout(event, 9)">
                                <i class="fas fa-th"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-dark">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-semibold">
                            <i class="fas fa-list me-2"></i>
                            Device Management
                        </h6>
                        <button class="btn btn-light btn-sm" onclick="toggleDeviceTable()">
                            <i class="fas fa-chevron-up text-dark" id="table-toggle-icon"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0" id="device-table">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover mb-0">
                            <thead class="table-dark">
                                <tr class="text-light">
                                    <th style="width: 50px;" class="text-center text-light">#</th>
                                    <th class="text-light">Device Name</th>
                                    <th class="text-light">IP/Domain</th>
                                    <th class="text-light">Type</th>
                                    <th class="text-light">Status</th>
                                    <th style="width: 150px;" class="text-center text-light">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cameras as $index => $cam)
                                <tr id="cam-row-{{ $index }}">
                                    <td class="text-center fw-semibold text-white">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-video text-primary me-2"></i>
                                            <span class="fw-medium text-white" style="margin-left: 5px;">{{ $cam['name'] }}</span>
                                        </div>
                                    </td>
                                    <td class="text-light">{{ $cam['ip'] ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-info-subtle text-info rounded-pill">
                                            {{ $cam['type'] ?? 'IP Camera' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($cam['online'] ?? false)
                                            <span class="badge bg-success rounded-pill">
                                                <i class="fas fa-circle me-1" style="font-size: 0.4rem;"></i>
                                                Online
                                            </span>
                                        @else
                                            <span class="badge bg-danger rounded-pill">
                                                <i class="fas fa-circle me-1" style="font-size: 0.4rem;"></i>
                                                Offline
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button class="btn btn-success" onclick="playStream({{ $index }})" title="Play Stream">
                                                <i class="fas fa-play"></i>
                                            </button>
                                            <button class="btn btn-warning" onclick="stopStream({{ $index }})" title="Stop Stream">
                                                <i class="fas fa-stop"></i>
                                            </button>
                                            <button class="btn btn-info" onclick="fullscreenVideo({{ $index }})" title="Fullscreen">
                                                <i class="fas fa-expand"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-light">
                                        <i class="fas fa-video fa-3x mb-3 opacity-25"></i>
                                        <p class="mb-0">No camera devices found</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row" id="video-grid">
        @php
        $testCam = [
            'name' => 'Test Camera (M3U8 Demo)',
            'ip' => 'test-streams.mux.dev',
            'port' => '',
            'type' => 'Demo',
            'online' => true,
            'stream_url' => 'https://test-streams.mux.dev/x36xhzz/x36xhzz.m3u8'
        ];

        // Tambahkan testCam ke array cameras
        $cameras[] = $testCam;
    @endphp
        @foreach($cameras as $index => $cam)
        <div class="col-lg-3 col-md-6 mb-4 video-item" data-camera-index="{{ $index }}" data-online="{{ $cam['online'] ? 'true' : 'false' }}">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden h-100 bg-dark">
                <div class="card-header bg-secondary border-bottom py-2 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-video text-primary me-2"></i>
                            <span class="fw-medium text-white" style="margin-left: 5px">{{ $cam['name'] }}</span>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-light" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end bg-dark border-secondary">
                                <li><a class="dropdown-item text-light" href="#" onclick="playStream({{ $index }})"><i class="fas fa-play me-2 text-success"></i>Play</a></li>
                                <li><a class="dropdown-item text-light" href="#" onclick="stopStream({{ $index }})"><i class="fas fa-stop me-2 text-warning"></i>Stop</a></li>
                                <li><a class="dropdown-item text-light" href="#" onclick="fullscreenVideo({{ $index }})"><i class="fas fa-expand me-2 text-info"></i>Fullscreen</a></li>
                                <li><hr class="dropdown-divider border-secondary"></li>
                                <li><a class="dropdown-item text-light" href="#" onclick="recordStream({{ $index }})"><i class="fas fa-record-vinyl me-2 text-danger"></i>Record</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0 position-relative">
                    <div class="video-container bg-dark">
                        <video id="video{{ $index }}" class="w-100 h-100" controls autoplay muted playsinline style="object-fit: cover;"></video>
                        <div id="overlay{{ $index }}" class="video-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center d-none">
                            <div class="text-center">
                                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                                <h6 class="text-white mb-2">Connection Failed</h6>
                                <p class="text-muted mb-3"><span></span></p>
                                <button class="btn btn-primary btn-sm" onclick="playStream({{ $index }})">
                                    <i class="fas fa-redo me-1"></i>
                                    Retry Connection
                                </button>
                            </div>
                        </div>
                        <div class="video-status position-absolute top-0 end-0 m-2">
                            @if($cam['online'] ?? false)
                                <span class="badge bg-success rounded-pill">
                                    <i class="fas fa-circle me-1" style="font-size: 0.4rem;"></i>
                                    LIVE
                                </span>
                            @else
                                <span class="badge bg-danger rounded-pill">
                                    <i class="fas fa-times me-1"></i>
                                    OFFLINE
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

</div>

<style>
    /* ... (CSS Anda yang sudah ada tetap sama) ... */
    :root {
        --primary-color: #0d6efd;
        --secondary-color: #6c757d;
        --success-color: #198754;
        --danger-color: #dc3545;
        --warning-color: #ffc107;
        --info-color: #0dcaf0;
        --dark-color: #212529;
        --light-color: #f8f9fa;
    }

    .bg-gradient-dark {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, #0a58ca 100%);
    }

    .nav-item {
        transition: all 0.3s ease;
        border-radius: 8px;
        margin: 0 4px;
        position: relative;
        overflow: hidden;
    }

    .nav-item:hover {
        background-color: rgba(255, 255, 255, 0.1);
        transform: translateY(-2px);
    }

    .nav-item.active {
        background-color: rgba(13, 110, 253, 0.15);
    }

    .active-indicator {
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 40px;
        height: 3px;
        background: var(--primary-color);
        border-radius: 2px;
    }

    .control-panel {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        border: 1px solid #495057;
    }

    .video-container {
        aspect-ratio: 16 / 9;
        background: linear-gradient(45deg, #2c3e50, #34495e);
        position: relative;
        overflow: hidden;
    }

    .video-overlay {
        background: linear-gradient(135deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.9) 100%);
        backdrop-filter: blur(5px);
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    }

    .video-item .card {
        background: #212529;
        border: 1px solid #495057;
    }

    .btn-group .btn.active {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }

    .table > :not(caption) > * > * {
        padding: 12px;
    }

    .badge {
        font-size: 0.75rem;
        font-weight: 500;
    }

    .device-status .badge {
        font-size: 0.8rem;
        padding: 8px 12px;
    }

    @media (max-width: 768px) {
        .control-buttons {
            margin-top: 1rem;
            width: 100%;
        }
        
        .video-item {
            margin-bottom: 1rem;
        }
        
        .nav-item {
            margin: 2px;
            padding: 12px 8px !important;
        }
        
        .nav-item h6 {
            font-size: 0.8rem;
        }
        
        .nav-item i {
            font-size: 1rem !important;
        }
    }

    .table-responsive {
        border-radius: 0;
    }

    .dropdown-menu {
        background-color: #212529 !important;
        border: 1px solid #495057;
        box-shadow: 0 4px 12px rgba(0,0,0,0.25);
        border-radius: 8px;
    }

    .dropdown-item:hover {
        background-color: #495057;
        color: #fff;
    }

    .video-status {
        z-index: 10;
    }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script>
    const hlsInstances = {};
    const cameras = @json($cameras);
    let currentLayout = 1; // Default ke 1x1
    let selectedCameraIndex = 0; // Index kamera yang sedang tampil
    const videoItems = document.querySelectorAll('.video-item');
    const cameraSelectDropdown = document.getElementById('camera-select-dropdown');
    
    // Inisialisasi: Pilih kamera pertama yang online atau kamera pertama
    const firstOnlineIndex = cameras.findIndex(cam => cam.online);
    selectedCameraIndex = firstOnlineIndex !== -1 ? firstOnlineIndex : 0;


    // Initialize page
    document.addEventListener('DOMContentLoaded', () => {
        // Set dropdown value based on initial selectedCameraIndex
        const selectElement = cameraSelectDropdown.querySelector('select');
        if (selectElement) {
             selectElement.value = selectedCameraIndex;
        }
        
        // Auto-play the initial selected camera if in 1x1 mode (or all if in default 4-grid)
        changeLayout(null, 1);
    });

    function playStream(index) {
        const video = document.getElementById(`video${index}`);
        const overlay = document.getElementById(`overlay${index}`);
        const overlayText = overlay.querySelector('span');

        if (!video) return;

        // Hide overlay
        overlay.classList.add('d-none');
        overlayText.textContent = '';

        // Destroy previous HLS instance
        if (hlsInstances[index]) {
            hlsInstances[index].destroy();
            delete hlsInstances[index];
        }

        const src = cameras[index].stream_url;
        if (!src) {
            showError(index, 'Stream URL not available');
            return;
        }
        
        if (Hls.isSupported()) {
            const hls = new Hls({
                lowLatencyMode: true,
                backBufferLength: 90,
                maxBufferLength: 30,
                maxMaxBufferLength: 600,
                maxBufferSize: 60 * 1000 * 1000,
                maxBufferHole: 0.5
            });

            hls.loadSource(src);
            hls.attachMedia(video);

            hls.on(Hls.Events.MANIFEST_PARSED, function() {
                video.play().catch(e => {
                    console.error('Autoplay failed:', e);
                    showError(index, 'Autoplay blocked by browser');
                });
            });

            hls.on(Hls.Events.ERROR, function(event, data) {
                console.error('HLS Error:', data);
                if (data.fatal) {
                    let errorMessage = 'Connection failed';
                    switch (data.type) {
                        case Hls.ErrorTypes.NETWORK_ERROR:
                            errorMessage = 'Network connection error';
                            break;
                        case Hls.ErrorTypes.MEDIA_ERROR:
                            errorMessage = 'Media decoding error';
                            hls.recoverMediaError();
                            return; // Don't show error for recoverable media errors
                        case Hls.ErrorTypes.MUX_ERROR:
                            errorMessage = 'Stream format error';
                            break;
                        default:
                            errorMessage = 'Unknown streaming error';
                            break;
                    }
                    showError(index, errorMessage);
                    hls.destroy();
                    delete hlsInstances[index];
                }
            });

            hlsInstances[index] = hls;
        
        } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
            video.src = src;
            video.addEventListener('loadedmetadata', function() {
                video.play().catch(e => {
                    console.error('Autoplay failed:', e);
                    showError(index, 'Autoplay blocked by browser');
                });
            });
            video.addEventListener('error', function() {
                showError(index, 'Failed to load stream');
            });
        } else {
            showError(index, 'HLS not supported in this browser');
        }
    }

    function stopStream(index) {
        const video = document.getElementById(`video${index}`);
        if (video) {
            video.pause();
            video.src = '';
        }
        
        if (hlsInstances[index]) {
            hlsInstances[index].destroy();
            delete hlsInstances[index];
        }
    }

    function showError(index, message) {
        const overlay = document.getElementById(`overlay${index}`);
        const overlayText = overlay.querySelector('span');
        overlayText.textContent = message;
        overlay.classList.remove('d-none');
    }

    function refreshAllStreams() {
        // Hanya refresh yang sedang tampil
        if (currentLayout === 1) {
            stopStream(selectedCameraIndex);
            setTimeout(() => playStream(selectedCameraIndex), 100);
        } else {
            cameras.forEach((cam, i) => {
                // Hanya refresh kamera yang online
                if (cam.online && cam.stream_url) {
                    stopStream(i);
                    setTimeout(() => playStream(i), 100);
                }
            });
        }
    }

    function stopAllStreams() {
        cameras.forEach((cam, i) => {
            stopStream(i);
        });
    }

    function selectSingleCamera(index) {
        index = parseInt(index);
        // Hentikan stream kamera lama
        if (currentLayout === 1) {
            stopStream(selectedCameraIndex);
        }

        selectedCameraIndex = index;
        updateVideoGridVisibility();
        
        // Putar stream kamera yang baru dipilih jika online
        if (cameras[index].online && cameras[index].stream_url) {
            playStream(index);
        }
    }

    function updateVideoGridVisibility() {
        videoItems.forEach(item => {
            const index = parseInt(item.dataset.cameraIndex);
            const isSelected = index === selectedCameraIndex;

            // Atur class col-* untuk grid
            item.className = item.className.replace(/\bcol-lg-\d+\b/g, '').trim();
            item.classList.remove('col-md-6', 'd-none'); // Bersihkan d-none sebelum penentuan

            switch(currentLayout) {
                case 1:
                    item.classList.add('col-lg-12', 'col-md-12');
                    if (isSelected) {
                        item.classList.remove('d-none');
                    } else {
                        item.classList.add('d-none');
                    }
                    break;
                case 4:
                    item.classList.add('col-lg-6', 'col-md-6');
                    item.classList.remove('d-none');
                    break;
                case 9:
                    item.classList.add('col-lg-4', 'col-md-6');
                    item.classList.remove('d-none');
                    break;
            }
        });
    }

    function changeLayout(event, layout) {
        // Hentikan semua stream saat berganti layout (opsional, tapi disarankan)
        stopAllStreams();

        currentLayout = layout;
        const buttons = document.querySelectorAll('.control-buttons .btn-group .btn');
        
        buttons.forEach(btn => btn.classList.remove('btn-primary', 'active'));
        buttons.forEach(btn => btn.classList.add('btn-outline-light'));
        
        // Tandai tombol layout yang aktif
        if (event) { 
            const clickedButton = event.target.closest('button');
            clickedButton.classList.remove('btn-outline-light');
            clickedButton.classList.add('btn-primary', 'active');
        } else {
            // Untuk inisialisasi
            const defaultBtn = document.querySelector(`.btn-group button[onclick*="changeLayout(event, ${layout})"]`);
            if (defaultBtn) {
                defaultBtn.classList.remove('btn-outline-light');
                defaultBtn.classList.add('btn-primary', 'active');
            }
        }
        
        // Tampilkan/sembunyikan dropdown pemilihan kamera
        if (layout === 1) {
            cameraSelectDropdown.style.display = 'block';
            
            // Putar stream kamera yang dipilih saat masuk mode 1x1
            if (cameras[selectedCameraIndex].online && cameras[selectedCameraIndex].stream_url) {
                 playStream(selectedCameraIndex);
            }
        } else {
            cameraSelectDropdown.style.display = 'none';

            // Putar semua stream kamera yang online saat masuk mode >1x1
            cameras.forEach((cam, i) => {
                 if (cam.online && cam.stream_url) {
                    // Stagger the connection
                    setTimeout(() => playStream(i), i * 500); 
                 }
            });
        }

        // Atur visibilitas dan ukuran grid
        updateVideoGridVisibility();
    }


    function fullscreenVideo(index) {
        const video = document.getElementById(`video${index}`);
        if (video) {
            if (video.requestFullscreen) {
                video.requestFullscreen();
            } else if (video.webkitRequestFullscreen) {
                video.webkitRequestFullscreen();
            } else if (video.msRequestFullscreen) {
                video.msRequestFullscreen();
            }
        }
    }

    function recordStream(index) {
        // Placeholder for record functionality
        alert(`Recording functionality for camera ${cameras[index].name} will be implemented`);
    }

    function toggleDeviceTable() {
        const table = document.getElementById('device-table');
        const icon = document.getElementById('table-toggle-icon');
        
        if (table.style.display === 'none' || table.style.display === '') {
            table.style.display = 'block';
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
        } else {
            table.style.display = 'none';
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        }
    }
</script>
@endpush