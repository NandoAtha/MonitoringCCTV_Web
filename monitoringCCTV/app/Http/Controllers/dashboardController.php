<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cameras = [
            [
                'name' => 'Kamera 1',
                'ip' => '192.168.1.10',
                'online' => true,
                'stream_url' => 'http://localhost:7001/live/kamera1/index.m3u8'
            ],
            [
                'name' => 'Kamera 2',
                'ip' => '192.168.1.11',
                'online' => false,
                'stream_url' => 'http://localhost:7001/live/kamera2/index.m3u8'
            ],
            [
                'name' => 'Kamera 3',
                'ip' => '192.168.1.12',
                'online' => false,
                'stream_url' => 'http://localhost:7001/live/kamera3/index.m3u8'
            ],
            [
                'name' => 'Kamera 4',
                'ip' => '192.168.1.12',
                'online' => false,
                'stream_url' => 'http://localhost:7001/live/kamera3/index.m3u8'
            ],
            [
                'name' => 'Kamera 5',
                'ip' => '192.168.1.12',
                'online' => false,
                'stream_url' => 'http://localhost:7001/live/kamera3/index.m3u8'
            ]
        ];

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

        return view('cctv.userMenu', compact('roles', 'permissions', 'users'));
    }

    public function store(Request $request)
    {
        $role = new Role();
        $role->name = $request->name;
        $role->permissions = $request->permissions ?? [];
        $role->save();

        return redirect()->back()->with('success', 'Role berhasil dibuat!');
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->permissions = $request->permissions ?? [];
        $role->save();

        return redirect()->back()->with('success', 'Role berhasil diperbarui!');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //http://localhost:5000/live/depan/index.m3u8
    }

    /**
     * Store a newly created resource in storage.
     */

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
   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
