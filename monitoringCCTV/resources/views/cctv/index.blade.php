@extends('layouts.admin')

@section('content')

<div class="container-fluid">
    <h2 class="mb-4">Monitoring CCTV</h2>

{{-- Kontrol Panel --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <button class="btn btn-success btn-sm" onclick="refreshAll()">Refresh All</button>
        <button class="btn btn-danger btn-sm" onclick="stopAll()">Stop All</button>
    </div>
    <div>
        <button class="btn btn-outline-light btn-sm" onclick="setLayout(1)">1</button>
        <button class="btn btn-outline-light btn-sm" onclick="setLayout(4)">4</button>
        <button class="btn btn-outline-light btn-sm" onclick="setLayout(9)">9</button>
    </div>
</div>

{{-- Tabel daftar kamera --}}
<div class="card mb-4 bg-dark text-white">
    <div class="card-header">Daftar Kamera</div>
    <div class="card-body">
        <table class="table table-dark table-striped table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Kamera</th>
                    <th>IP Address</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cameras as $index => $cam)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $cam['name'] }}</td>
                        <td>{{ $cam['ip'] }}:{{ $cam['port'] }}</td>
                        <td>
                            @if($cam['online'])
                                <span class="badge bg-success">Online</span>
                            @else
                                <span class="badge bg-danger">Offline</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary" onclick="playStream('{{ $cam['stream_url'] }}', 'video_{{ $index }}')">Play</button>
                                <button class="btn btn-sm btn-danger" onclick="stopStream('video_{{ $index }}')">Stop</button>
                                <button class="btn btn-sm btn-secondary" onclick="toggleFullscreen('video_{{ $index }}')">Fullscreen</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada kamera terdaftar</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="row" id="video-grid">
        {{-- Kamera test --}}
        @php
            $testCam = [
                'name' => 'Test Camera (M3U8 Demo)',
                'ip' => 'test-streams.mux.dev',
                'port' => '',
                'online' => true,
                'stream_url' => 'https://test-streams.mux.dev/x36xhzz/x36xhzz.m3u8'
            ];
        @endphp

{{-- Grid video --}}
<div class="row" id="video-grid">
    @foreach(array_merge($cameras, [$testCam]) as $index => $cam)
        <div class="col-md-4 mb-4 video-col">
            <div class="card bg-dark text-white camera-box">
                <div class="card-header">{{ $cam['name'] }}</div>
                <div class="card-body text-center position-relative">
                    <video id="video_{{ $index }}" width="100%" height="240" controls autoplay muted playsinline></video>
                    <p class="mt-2 small text-muted">{{ $cam['name'] }}</p>
                    <div class="overlay d-none" id="overlay_{{ $index }}">
                        <span class="text-danger fw-bold">Stream Error</span>
                    </div>
                    <div class="mt-2">
                        <button class="btn btn-sm btn-primary" onclick="playStream('{{ $cam['stream_url'] }}', 'video_{{ $index }}')">Play</button>
                        <button class="btn btn-sm btn-danger" onclick="stopStream('video_{{ $index }}')">Stop</button>
                        <button class="btn btn-sm btn-secondary" onclick="toggleFullscreen('video_{{ $index }}')">Fullscreen</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
```

</div>
@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>

<script>
    let players = {};

    function playStream(url, videoId) {
        let video = document.getElementById(videoId);
        let overlay = document.getElementById('overlay_' + videoId.split('_')[1]);

        if (Hls.isSupported()) {
            if (players[videoId]) players[videoId].destroy();

            let hls = new Hls({autoStartLoad:true});
            hls.loadSource(url);
            hls.attachMedia(video);

            hls.on(Hls.Events.ERROR, function(event, data) {
                if (data.fatal) {
                    overlay.classList.remove('d-none');
                }
            });

            players[videoId] = hls;
        } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
            video.src = url;
        }
        video.play();
        overlay.classList.add('d-none');
    }

    function stopStream(videoId) {
        let video = document.getElementById(videoId);
        let overlay = document.getElementById('overlay_' + videoId.split('_')[1]);

        if (players[videoId]) {
            players[videoId].destroy();
            delete players[videoId];
        }
        video.pause();
        video.removeAttribute('src');
        video.load();
        overlay.classList.add('d-none');
    }

    function stopAll() {
        Object.keys(players).forEach(id => stopStream(id));
    }

    function refreshAll() {
        Object.keys(players).forEach(id => {
            let video = document.getElementById(id);
            let url = players[id].url;
            stopStream(id);
            playStream(url, id);
        });
    }

    function toggleFullscreen(videoId) {
        let video = document.getElementById(videoId);
        if (video.requestFullscreen) {
            video.requestFullscreen();
        } else if (video.webkitRequestFullscreen) {
            video.webkitRequestFullscreen();
        }
    }

    function setLayout(cols) {
        let grid = document.getElementById("video-grid");
        let colClass = "col-md-" + (12/cols);
        Array.from(grid.getElementsByClassName("video-col")).forEach(el => {
            el.className = "mb-4 video-col " + colClass;
        });
    }
</script>

<style>
    .camera-box { border-radius: 10px; overflow: hidden; }
    .overlay {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.6);
        display: flex; align-items: center; justify-content: center;
    }
</style>

@endpush
