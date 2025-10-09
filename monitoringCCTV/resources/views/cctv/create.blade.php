@extends('layouts.admin')

@section('title', 'Tambah Kamera Baru')

@section('content')

<div class="bg-dark vh-100 d-flex flex-column">

    <div class="container-fluid flex-grow-1 mt-4">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card theme-card bg-dark-subtle border-secondary text-white shadow-sm">
                    <div class="card-header theme-card-header bg-secondary text-white">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-video me-2"></i> Tambah Perangkat Kamera Baru
                        </h5>
                    </div>

                    <div class="card-body">
                        {{-- Pesan sukses --}}
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        {{-- Form tambah kamera --}}
                        <form action="{{ route('cctv.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label text-white">Nama Perangkat</label>
                                <input type="text" class="form-control bg-dark text-white border-secondary @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Kamera Utama Halaman" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="location" class="form-label text-white">Lokasi Kamera</label>
                                <input type="text" class="form-control bg-dark text-white border-secondary @error('location') is-invalid @enderror"
                                    id="location" name="location" value="{{ old('location') }}" placeholder="Contoh: Kantor Diskominfo" required>
                                @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="ip" class="form-label text-white">IP Address</label>
                                    <input type="text" class="form-control bg-dark text-white border-secondary @error('ip') is-invalid @enderror"
                                        id="ip" name="ip" value="{{ old('ip') }}" placeholder="192.168.1.100" required>
                                    @error('ip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="port" class="form-label text-white">Port (Default: 554)</label>
                                    <input type="number" class="form-control bg-dark text-white border-secondary @error('port') is-invalid @enderror"
                                        id="port" name="port" value="{{ old('port') ?? 554 }}">
                                    @error('port')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="channel" class="form-label text-white">Channel</label>
                                    <input type="number" class="form-control bg-dark text-white border-secondary @error('channel') is-invalid @enderror"
                                        id="channel" name="channel" value="{{ old('channel') }}" placeholder="Contoh: 1 atau 2">
                                    @error('channel')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="username" class="form-label text-white">Username RTSP</label>
                                    <input type="text" class="form-control bg-dark text-white border-secondary @error('username') is-invalid @enderror"
                                        id="username" name="username" value="{{ old('username') }}" placeholder="user_rtsp" required>
                                    @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label text-white">Password RTSP</label>
                                    <input type="password" class="form-control bg-dark text-white border-secondary @error('password') is-invalid @enderror"
                                        id="password" name="password" value="{{ old('password') }}" placeholder="password_rtsp" required>
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Field stream_url dihilangkan karena di-generate di controller --}}
                            
                            <div class="col-md-6 mb-3 d-flex align-items-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="online" name="online" value="1" checked>
                                    <label class="form-check-label text-white ms-2" for="online">Online Saat Ini</label>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <a href="{{ route('cctv.index') }}" class="btn btn-secondary me-2">
                                    <i class="fas fa-arrow-left me-1"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-primary fw-semibold">
                                    <i class="fas fa-save me-1"></i> Simpan Kamera
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer theme-card-footer bg-secondary text-end">
                        <small class="text-white-50">Pastikan data kamera valid sebelum disimpan.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-dark-subtle {
        background-color: #2c3034 !important;
    }

    .border-secondary {
        border-color: #495057 !important;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
</style>

@endsection