<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mendefinisikan data kamera secara statis
        $cameras = [
            'Kominfo Kabupaten Malang' => [
                [
                    'name' => 'Resepsionis',
                    'ip' => '10.10.100.26',
                    'port' => '554',
                    // PERBAIKAN SINTAKS: Menambahkan '&' sebelum subtype=0
                    'rtsp_url' => 'rtsp://KadisKominfo:MalangKab2811@10.10.100.26:554/cam/realmonitor?channel=1&subtype=0',
                    'stream_url' => url('stream/kominfo-resepsionis.m3u8'),
                    'online' => true,
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
                    'image_placeholder' => asset('images/cctv_masuk_dummy.jpg')
                ],
            ],
            
            // Tambahkan grup lain yang mungkin ada untuk konsistensi
            'Lokasi Test Tambahan' => [ 
                [
                    'name' => 'Jalur Buntu',
                    'ip' => '10.10.100.26',
                    'port' => '554',
                    'rtsp_url' => 'rtsp://KadisKominfo:MalangKab2811@10.10.100.26:554/cam/realmonitor?channel=5&subtype=0',
                    'stream_url' => url('stream/kominfo-buntu.m3u8'),
                    'online' => false, // Set false jika stream ini tidak dijalankan di FFmpeg
                    'image_placeholder' => asset('images/cctv_buntu_dummy.jpg')
                ],
            ]
        ];
        // Melempar data kamera ke view 'landing'
        return view('landing', compact('cameras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}