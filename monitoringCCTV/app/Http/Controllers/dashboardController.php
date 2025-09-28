<?php

namespace App\Http\Controllers;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
        public function index()
    {
        $xmlPath = storage_path('app/cctv_devices.xml');

        if (!file_exists($xmlPath)) {
            abort(404, "File XML CCTV tidak ditemukan di: {$xmlPath}");
        }

        libxml_use_internal_errors(true);
        $xml = simplexml_load_file($xmlPath);

        if ($xml === false) {
            $errs = libxml_get_errors();
            $msg = collect($errs)->map(fn($e) => trim($e->message))->implode('; ');
            abort(500, "Gagal parsing XML: {$msg}");
        }

        $cameras = [];
        foreach ($xml->Device as $device) {
            $attrs = $device->attributes();

            $name     = (string) ($attrs['name'] ?? 'Unknown');
            $ip       = (string) ($attrs['domain'] ?? $attrs['ip'] ?? '');
            $port     = (string) ($attrs['port'] ?? '554');
            $username = (string) ($attrs['username'] ?? '');
            $password = (string) ($attrs['password'] ?? '');

            $rtspUrl = "rtsp://{$username}:{$password}@{$ip}:{$port}/Streaming/Channels/101";

            $slug = Str::slug($name ?: $ip ?: 'camera');

            $cameras[] = [
                'name'       => $name,
                'ip'         => $ip,
                'port'       => $port,
                'username'   => $username,
                'password'   => $password,
                'rtsp_url'   => $rtspUrl,
                'stream_url' => url("streams/{$slug}.m3u8"),
                'online'     => false, 
            ];
        }

        return view('cctv.index', compact('cameras'));
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
    // public function accounts()
    // {

    //     return view('cctv.accounts');
    // }

    public function create() {}
    public function store(Request $request) {}
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
