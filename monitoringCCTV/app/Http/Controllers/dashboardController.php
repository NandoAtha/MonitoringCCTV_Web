<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use App\Models\Camera;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan semua kamera dari database.
     */
    public function index()
    {
        try {
            // Ambil semua kamera dari database
            $cameras = Camera::orderBy('created_at', 'desc')->get();

            // Hitung statistik
            $totalCameras = $cameras->count();
            $onlineCameras = $cameras->where('online', true)->count();
            $offlineCameras = $totalCameras - $onlineCameras;

            // Jika belum ada kamera
            if ($totalCameras === 0) {
                session()->flash('warning', 'Belum ada kamera yang terdaftar. Tambahkan kamera terlebih dahulu.');
            }

            return view('cctv.index', compact(
                'cameras',
                'totalCameras',
                'onlineCameras',
                'offlineCameras'
            ));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal memuat data kamera: ' . $e->getMessage());
        }
    }


    public function playback()
    {
        return view('cctv.playBack');
    }

    public function settings()
    {
        return view('cctv.settings');
    }

    public function logs()
    {
        $logs = [
            ['time' => '2025-08-12 12:30', 'event' => 'Kamera 1 Online'],
            ['time' => '2025-08-12 12:35', 'event' => 'Kamera 2 Offline']
        ];

        return view('cctv.logs', compact('logs'));
    }

    public function users()
    {
        $users = [
            ['name' => 'Admin', 'role' => 'Super Admin'],
            ['name' => 'Operator', 'role' => 'Viewer']
        ];
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();

        return view('cctv.userMenu', compact('users', 'roles', 'permissions'));
    }

    /**
     * Form tambah kamera baru
     */
    public function create()
    {
        return view('cctv.create');
    }

    /**
     * Simpan kamera baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'ip'         => 'required|ip',
            'port'       => 'nullable|numeric|min:1|max:65535',
            'username'   => 'required|string', // NEW: Username
            'password'   => 'required|string', // NEW: Password
            'channel'    => 'required|numeric', // NEW: Channel/Stream Path
            'online'     => 'nullable|boolean',
            'type'       => 'nullable|string|max:100',
            'location'   => 'required|string|max:255',
            // 'rtsp_url' dan 'stream_url' dihapus dari validasi karena di-generate
        ]);

        // --- LOGIKA GENERASI URL ---

        // 1. Buat RTSP URL dari input yang divalidasi
        $ip = $validated['ip'];
        $port = $validated['port'] ?? '554';
        $username = $validated['username'];
        $password = $validated['password'];
        $channel = $validated['channel'];

        // Format RTSP: rtsp://user:pass@ip:port/channel
        $rtspUrl = "rtsp://{$username}:{$password}@{$ip}:{$port}/cam/realmonitor?channel={$channel}&subtype=1";

        // 2. Buat Stream URL (HLS) dari nama kamera
        $cameraName = $validated['name'];
        $streamUrl = 'streams/' . $cameraName . '.m3u8';

        // --- AKHIR LOGIKA GENERASI URL ---

        Camera::create([
            'name'       => $validated['name'],
            'ip'         => $validated['ip'],
            'port'       => $port,
            // Simpan RTSP URL yang sudah di-generate
            'rtsp_url'   => $rtspUrl,
            // Simpan Stream URL yang sudah di-generate
            'stream_url' => $streamUrl,
            // ✅ gunakan has() agar checkbox unchecked tidak error
            'online'     => $request->has('online'),
            'type'       => $validated['type'] ?? 'IP Camera',
            'location'   => $validated['location'],

            // Simpan username dan password secara terpisah (opsional, tergantung skema DB Anda)
            // 'username' => $username, 
            // 'password' => $password, 
        ]);

        return redirect()
            ->route('cctv.index')
            ->with('success', 'Kamera baru berhasil ditambahkan!');
    }


    public function show(Camera $camera)
    {
        return view('cctv.show', compact('camera'));
    }

    public function edit(Camera $camera)
    {
        return view('cctv.edit', compact('camera'));
    }

    public function update(Request $request, Camera $camera)
    {
        $validatedData = $request->validate([
            'name'       => 'required|string|max:255',
            'ip'         => 'required|ip',
            'port'       => 'nullable|numeric|min:1|max:65535',
            'rtsp_url'   => 'required|string',
            'stream_url' => 'required|string',
            'online'     => 'boolean',
            'type'       => 'nullable|string|max:100',
            'location'   => 'required|string|max:255',
        ]);

        $camera->update($validatedData);
        return redirect()->route('cctv.index')->with('success', 'Kamera berhasil diperbarui!');
    }

    public function destroy(Camera $camera)
    {
        // Panggil method delete() pada model Camera
        $camera->delete();

        return redirect()
            ->route('cctv.index')
            ->with('success', 'Kamera berhasil dihapus!');
    }
}
