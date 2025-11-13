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
                                All Devices: {{ $totalCameras }}
                            </span>
                            <span class="badge bg-primary rounded-pill px-3 py-2 ms-2">
                                <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                                Online: {{ $onlineCameras }}
                            </span>
                            <span class="badge bg-danger rounded-pill px-3 py-2 ms-2">
                                <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                                Offline: {{ $offlineCameras }}
                            </span>

                        </div>
                    </div>
                    <div class="control-buttons d-flex align-items-center flex-wrap mt-2 mt-md-0">
                        <a href="{{ route('cctv.create') }}" class="btn btn-success btn-sm mr-2">
                            <i class="fas fa-plus me-1"></i>
                            Add New Camera
                        </a>
                        <button class="btn btn-primary btn-sm mr-2" onclick="refreshAllStreams()">
                            <i class="fas fa-sync-alt me-1"></i>
                            Refresh All
                        </button>
                        <button class="btn btn-secondary btn-sm me-2" onclick="stopAllStreams()">
                            <i class="fas fa-stop me-1"></i>
                            Stop All
                        </button>
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
                                    <th class="text-light">Location</th>
                                    <th class="text-light">Status</th>
                                    <th style="width: 200px;" class="text-center text-light">Actions</th> {{-- Diperluas --}}
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
                                    <td class="text-light">{{ $cam['location'] ?? 'N/A' }}</td>
                                    
                                    <td>
                                        @if($cam['online'] ?? false)
                                        <span class="badge bg-success rounded-pill">
                                            Online
                                        </span>
                                        @else
                                        <span class="badge bg-danger rounded-pill">
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
                                            
                                            {{--  TOMBOL DELETE BARU --}}
                                            
                                            <button class="btn btn-danger delete-camera-btn" data-id="{{ $cam->id }}" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            
                                            {{-- Form tersembunyi untuk DELETE --}}
                                            <form id="delete-form-{{ $cam->id }}" action="{{ route('cctv.destroy', $cam->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>

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
        @foreach($cameras as $index => $cam)
        <div class="col-lg-4 col-md-6 mb-4 video-item" data-camera-index="{{ $index }}" data-online="{{ $cam['online'] ? 'true' : 'false' }}">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden h-100 bg-dark">
                <div class="card-header bg-secondary border-bottom py-2 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-video text-primary me-2"></i>
                            <span class="fw-medium text-white" style="margin-left: 5px">{{ $cam['name'] }}</span>
                        </div>
                        <div class="video-status">
                            @if($cam['online'] ?? false)
                            <span class="badge bg-success rounded-pill">
                                <i class="fas fa-circle me-1"></i>
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
                <div class="card-body p-0">
                    <div class="video-container bg-dark">
                        <video id="video{{ $index }}" class="w-100 h-100 d-block" controls autoplay muted playsinline style="object-fit: contain;"></video>
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

                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script>
    const hlsInstances = {};
    const cameras = @json($cameras);
    let currentLayout = 9;
    let selectedCameraIndex = 0;
    const videoItems = document.querySelectorAll('.video-item');
    const cameraSelectDropdown = document.getElementById('camera-select-dropdown');

    // Initialize page
    document.addEventListener('DOMContentLoaded', () => {
        initializeLayout();
        // 🔥 Tambahkan event listener untuk tombol hapus
        attachDeleteEventListeners(); 
    });

    function initializeLayout() {
        videoItems.forEach(item => {
            item.className = item.className.replace(/\bcol-lg-\d+\b/g, '').trim();
            item.classList.remove('d-none');
            item.classList.add('col-lg-4', 'col-md-6');
        });

        cameras.forEach((cam, i) => {
            if (cam.online && cam.stream_url) {
                setTimeout(() => playStream(i), i * 500);
            }
        });
    }

    // 🔥 FUNGSI BARU UNTUK MENGELOLA HAPUS KAMERA
    function attachDeleteEventListeners() {
        document.querySelectorAll('.delete-camera-btn').forEach(button => {
            button.addEventListener('click', function() {
                const cameraId = this.getAttribute('data-id');
                const cameraName = this.closest('tr').querySelector('span').textContent;
                
                if (confirm(`Are you sure you want to delete camera: "${cameraName}"? This action cannot be undone.`)) {
                    document.getElementById(`delete-form-${cameraId}`).submit();
                }
            });
        });
    }

    // --- Core Streaming Functions (Unchanged) ---
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
                liveSyncDuration: 1,
                liveMaxLatencyDuration: 3,
                liveDurationInfinity: true,
                manifestLoadingTimeOut: 15000,
                manifestLoadingMaxRetry: 10,
                manifestLoadingRetryDelay: 1000,
                maxLiveSyncPlaybackRate: 1.5,
                enableWorker: true
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
        // Only refresh currently visible cameras (all of them in 3x3)
        cameras.forEach((cam, i) => {
            if (cam.online && cam.stream_url) {
                stopStream(i);
                setTimeout(() => playStream(i), 100);
            }
        });
    }

    function stopAllStreams() {
        cameras.forEach((cam, i) => {
            stopStream(i);
        });
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