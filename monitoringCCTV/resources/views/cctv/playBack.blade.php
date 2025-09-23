@extends('layouts.admin')

@section('title', 'Playback CCTV')

@section('content')

<div class="bg-dark vh-100 d-flex flex-column">


<div class="container-fluid flex-grow-1 mt-4">
    <div class="row h-100">

        <div class="col-lg-3 col-md-4">
            <div class="card bg-dark-subtle h-100 border-secondary">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0 fw-semibold"><i class="fas fa-sliders-h me-2"></i>Playback Controls</h6>
                </div>
                <div class="card-body text-white d-flex flex-column">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Device</label>
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text bg-dark text-white border-secondary"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control bg-dark text-white border-secondary" placeholder="Search device...">
                        </div>
                        <ul class="list-group" style="max-height: 150px; overflow-y: auto;">
                            <li class="list-group-item bg-dark text-white border-secondary d-flex align-items-center">
                                <i class="fas fa-video text-primary me-2"></i> Kamera 1
                            </li>
                            <li class="list-group-item bg-dark text-white border-secondary d-flex align-items-center">
                                <i class="fas fa-video text-muted me-2"></i> Kamera 2
                            </li>
                            <li class="list-group-item bg-dark text-white border-secondary d-flex align-items-center">
                                <i class="fas fa-video text-muted me-2"></i> Kamera 3
                            </li>
                        </ul>
                    </div>

                    <hr class="border-secondary">

                    <form>
                        <div class="mb-3">
                            <label for="recordType" class="form-label fw-semibold">Record Type</label>
                            <select id="recordType" class="form-select form-select-sm bg-dark text-white border-secondary">
                                <option selected>All Records</option>
                                <option value="1">Motion Detection</option>
                                <option value="2">Alarm</option>
                                <option value="3">Manual Record</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="streamType" class="form-label fw-semibold">Stream Type</label>
                            <select id="streamType" class="form-select form-select-sm bg-dark text-white border-secondary">
                                <option selected>Main Stream</option>
                                <option value="1">Sub Stream</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="startTime" class="form-label fw-semibold">Start Time</label>
                            <input type="datetime-local" id="startTime" class="form-control form-control-sm bg-dark text-white border-secondary">
                        </div>
                        <div class="mb-3">
                            <label for="endTime" class="form-label fw-semibold">End Time</label>
                            <input type="datetime-local" id="endTime" class="form-control form-control-sm bg-dark text-white border-secondary">
                        </div>
                        <div class="mt-auto">
                            <button type="submit" class="btn btn-primary w-100 fw-semibold"><i class="fas fa-search me-2"></i>Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-9 col-md-8 d-flex flex-column">
            <div class="row flex-grow-1" id="playback-grid">
                <div class="col-12 h-100">
                    <div class="video-container bg-dark-gradient rounded-3 h-100 position-relative">
                        <video id="playback-video-0" class="w-100 h-100" style="object-fit: cover;"></video>
                        <div class="video-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center">
                            <div class="text-center">
                                <i class="fas fa-film fa-4x text-muted mb-3"></i>
                                <h5 class="text-white">Select a recording to play</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="playback-controls bg-dark-subtle rounded-3 p-2 mt-3 shadow-sm">
                <div class="timeline-bar mb-2">
                    <div class="timeline-progress" style="width: 30%;"></div>
                    <div class="time-markers">
                        @for ($i = 0; $i <= 24; $i+=2)
                        <span>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00</span>
                        @endfor
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <button class="btn btn-outline-light btn-sm" title="Export Clip"><i class="fas fa-download"></i></button>
                    </div>
                    <div class="btn-toolbar">
                        <div class="btn-group btn-group-sm me-3" role="group">
                            <button class="btn btn-outline-light"><i class="fas fa-backward"></i></button>
                            <button class="btn btn-outline-light"><i class="fas fa-stop"></i></button>
                            <button class="btn btn-primary"><i class="fas fa-play"></i></button>
                            <button class="btn btn-outline-light"><i class="fas fa-forward"></i></button>
                        </div>
                        <div class="btn-group btn-group-sm me-3" role="group">
                             <button class="btn btn-outline-light"><i class="fas fa-search-minus"></i></button>
                             <button class="btn btn-outline-light"><i class="fas fa-search-plus"></i></button>
                        </div>
                        <div class="btn-group btn-group-sm" role="group">
                            <button class="btn btn-outline-light"><i class="fas fa-volume-down"></i></button>
                            <input type="range" class="form-range mx-2" style="width: 80px;">
                            <button class="btn btn-outline-light"><i class="fas fa-volume-up"></i></button>
                        </div>
                    </div>
                    <div>
                        <div class="btn-group btn-group-sm" role="group">
                            <button class="btn btn-outline-light active"><i class="fas fa-square"></i></button>
                            <button class="btn btn-outline-light"><i class="fas fa-th-large"></i></button>
                            <button class="btn btn-outline-light"><i class="fas fa-th"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<style>
    :root {
        --primary-color: #0d6efd;
    }

    .bg-dark-subtle {
        background-color: #2c3034;
    }

    .border-secondary {
        border-color: #495057 !important;
    }

    .bg-dark-gradient {
        background: linear-gradient(45deg, #2c3e50, #34495e);
    }

    .nav-item {
        transition: all 0.3s ease;
        border-radius: 8px;
        position: relative;
    }

    .nav-item:hover {
        background-color: rgba(255, 255, 255, 0.1);
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

    .video-overlay {
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(2px);
    }
    
    .playback-controls {
        color: #fff;
    }

    .timeline-bar {
        width: 100%;
        height: 15px;
        background-color: #495057;
        border-radius: 5px;
        position: relative;
        cursor: pointer;
        overflow: hidden;
    }

    .timeline-progress {
        height: 100%;
        background-color: var(--primary-color);
        border-radius: 5px;
    }
    
    .time-markers {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        display: flex;
        justify-content: space-between;
        font-size: 0.7rem;
        color: #adb5bd;
        margin-top: 5px;
    }
    
    .list-group-item {
        cursor: pointer;
    }
    
    .list-group-item:hover {
        background-color: #343a40 !important;
    }

    input[type="datetime-local"]::-webkit-calendar-picker-indicator {
        filter: invert(1);
        cursor: pointer;
    }
</style>
@endsection