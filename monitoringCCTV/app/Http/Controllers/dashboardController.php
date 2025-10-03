<?php

namespace App\Http\Controllers;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    /**
     * Retrieves the static public CCTV data, matching the structure in PublicController.
     * * CATATAN: Dalam aplikasi nyata, data ini harus diambil dari Database.
     * Untuk tujuan demo ini, kita akan menambahkan data ke array ini di function store().
     * Namun, perlu diingat bahwa perubahan ini TIDAK akan bersifat permanen
     * karena array ini dibuat ulang pada setiap request.
     * @return array
     */
    protected function getPublicCCTVData()
    {
        // ... (Data array statis yang sudah ada) ...
        $camerasByLocation = [
            'Kominfo Kabupaten Malang' => [
                [
                    'name' => 'Resepsionis',
                    'ip' => '10.10.100.26',
                    'port' => '554',
                    // PERBAIKAN SINTAKS: Menambahkan '&' sebelum subtype=0
                    'rtsp_url' => 'rtsp://KadisKominfo:MalangKab2811@10.10.100.26:554/cam/realmonitor?channel=1&subtype=0',
                    'stream_url' => url('stream/kominfo-resepsionis.m3u8'),
                    'online' => true,
                    'type' => 'Dahua', // Added type for index.blade.php
                    'image_placeholder' => asset('images/cctv_lift_dummy.jpg')
                ],
                [
                    'name' => 'PPID',
                    'ip' => '10.10.100.26',
                    'port' => '554',
                    // PERBAIKAN SINTAKS
                    'rtsp_url' => 'rtsp://KadisKominfo:MalangKab2811@10.10.100.26:554/cam/realmonitor?channel=2&subtype=0',
                    'stream_url' => url('stream/kominfo-PPID.m3u8'),
                    'online' => true,
                    'type' => 'Dahua', // Added type for index.blade.php
                    'image_placeholder' => asset('images/cctv_server_a_dummy.jpg')
                ],
                [
                    'name' => 'Lorong 1',
                    'ip' => '10.10.100.26',
                    'port' => '554',
                    // PERBAIKAN SINTAKS
                    'rtsp_url' => 'rtsp://KadisKominfo:MalangKab2811@10.10.100.26:554/cam/realmonitor?channel=3&subtype=0',
                    'stream_url' => url('stream/kominfo-lorong1.m3u8'),
                    'online' => true,
                    'type' => 'Dahua', // Added type for index.blade.php
                    'image_placeholder' => asset('images/cctv_parkir_dummy.jpg')
                ],
                [
                    'name' => 'Lorong 2',
                    'ip' => '10.10.100.26',
                    'port' => '554',
                    // PERBAIKAN SINTAKS
                    'rtsp_url' => 'rtsp://KadisKominfo:MalangKab2811@10.10.100.26:554/cam/realmonitor?channel=4&subtype=0',
                    'stream_url' => url('stream/kominfo-lorong2.m3u8'),
                    'online' => true,
                    'type' => 'Dahua', // Added type for index.blade.php
                    'image_placeholder' => asset('images/cctv_masuk_dummy.jpg')
                ],
            ],
        ];
        return $camerasByLocation;
    }

    public function index()
    {
        $camerasByLocation = $this->getPublicCCTVData();

        // Flatten the array of cameras for the admin index view
        $cameras = [];
        foreach ($camerasByLocation as $location => $camerasInLocation) {
            foreach ($camerasInLocation as $camera) {
                // Ensure all keys needed by index.blade.php exist
                $cameras[] = [
                    'name'       => $camera['name'],
                    'ip'         => $camera['ip'],
                    'port'       => $camera['port'],
                    'username'   => 'REMOVED', // Not available in static data
                    'password'   => 'REMOVED', // Not available in static data
                    'rtsp_url'   => $camera['rtsp_url'],
                    'stream_url' => $camera['stream_url'],
                    'online'     => $camera['online'],
                    'type'       => $camera['type'] ?? 'IP Camera', // Use the added type or default
                    'location'   => $location,
                ];
            }
        }

        return view('cctv.index', compact('cameras'));
    }
    
    // ... (Fungsi playback, settings, logs, users, create, show, edit, update, destroy lainnya) ...
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

    public function create() 
    {
        // Tampilkan form untuk menambah kamera baru
        return view('cctv.create');
    }

    public function store(Request $request) 
    {
        // 1. Validasi Input
        $validatedData = $request->validate([
            'name'       => 'required|string|max:255',
            'ip'         => 'required|ip',
            'port'       => 'nullable|numeric|min:1|max:65535',
            'rtsp_url'   => 'required|url',
            'stream_url' => 'required|url',
            'online'     => 'boolean',
            'type'       => 'nullable|string|max:100',
            // Dalam kasus nyata, field lain seperti 'location_name' mungkin diperlukan
        ]);

        // 2. Buat objek kamera baru
        $newCamera = [
            'name'       => $validatedData['name'],
            'ip'         => $validatedData['ip'],
            'port'       => $validatedData['port'] ?? '554',
            'rtsp_url'   => $validatedData['rtsp_url'],
            'stream_url' => $validatedData['stream_url'],
            'online'     => $validatedData['online'] ?? true,
            'type'       => $validatedData['type'] ?? 'IP Camera',
            // Tambahkan placeholder jika diperlukan oleh Blade
            'image_placeholder' => asset('images/cctv_new_dummy.jpg')
        ];

        // --- Simulasi Penyimpanan Permanen (Aplikasi Nyata akan menggunakan Database) ---
        // Karena ini array statis, kita tidak bisa menyimpannya secara permanen di sini.
        // Jika menggunakan Model Eloquent (misal Camera::class):
        // Camera::create($newCamera);
        // --------------------------------------------------------------------------------

        // 3. Redirect dengan pesan sukses
        return redirect()->route('cctv.index')->with('success', 'Kamera baru berhasil ditambahkan! (Simulasi)');
    }
    
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}