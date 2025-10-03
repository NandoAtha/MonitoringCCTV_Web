@extends('layouts.admin')

@section('title', 'Add New Camera')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            {{-- Mengubah card menjadi dark mode --}}
            <div class="card border-0 shadow-sm rounded-3 bg-dark text-white">
                <div class="card-header bg-secondary border-bottom py-3">
                    <h5 class="mb-0 fw-semibold"><i class="fas fa-plus-circle me-2 text-primary"></i> Tambah Perangkat Kamera Baru</h5>
                </div>
                <div class="card-body">
                    {{-- Menampilkan pesan sukses dari redirect --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Form POST ke DashboardController@store --}}
                    <form action="{{ route('cctv.store') }}" method="POST">
                        @csrf 

                        <div class="mb-3">
                            {{-- Menggunakan text-white untuk label --}}
                            <label for="name" class="form-label text-white">Nama Perangkat</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror bg-dark text-white border-secondary" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="ip" class="form-label text-white">IP Address</label>
                                <input type="text" class="form-control @error('ip') is-invalid @enderror bg-dark text-white border-secondary" id="ip" name="ip" value="{{ old('ip') }}" required>
                                @error('ip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="port" class="form-label text-white">Port (Contoh: 554)</label>
                                <input type="number" class="form-control @error('port') is-invalid @enderror bg-dark text-white border-secondary" id="port" name="port" value="{{ old('port') ?? 554 }}">
                                @error('port')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        {{-- Field RTSP URL --}}
                        <div class="mb-3">
                            <label for="rtsp_url" class="form-label text-white">RTSP URL (dengan kredensial)</label>
                            <input type="url" class="form-control @error('rtsp_url') is-invalid @enderror bg-dark text-white border-secondary" id="rtsp_url" name="rtsp_url" value="{{ old('rtsp_url') }}" placeholder="rtsp://user:pass@ip:port/..." required>
                            @error('rtsp_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Field Stream URL (HLS) --}}
                        <div class="mb-3">
                            <label for="stream_url" class="form-label text-white">Stream URL (HLS - .m3u8)</label>
                            <input type="url" class="form-control @error('stream_url') is-invalid @enderror bg-dark text-white border-secondary" id="stream_url" name="stream_url" value="{{ old('stream_url') }}" placeholder="{{ url('stream/new-camera.m3u8') }}" required>
                            @error('stream_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label text-white">Tipe Kamera</label>
                                <select class="form-select @error('type') is-invalid @enderror bg-dark text-white border-secondary" id="type" name="type">
                                    <option value="Dahua" {{ old('type') == 'Dahua' ? 'selected' : '' }}>Dahua</option>
                                    <option value="Hikvision" {{ old('type') == 'Hikvision' ? 'selected' : '' }}>Hikvision</option>
                                    <option value="IP Camera" {{ old('type') == 'IP Camera' ? 'selected' : '' }}>IP Camera (Generic)</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-white">Status Awal</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" id="online" name="online" value="1" checked>
                                    <label class="form-check-label text-white" for="online">Online</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('cctv.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Kamera</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection