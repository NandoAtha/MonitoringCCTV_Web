<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Gunakan DashboardController untuk mengakses data shared
use App\Http\Controllers\DashboardController;
use App\Models\Camera;

class PublicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        $cameras = Camera::orderBy('created_at', 'desc')
            ->get()
            ->groupBy('location'); //  dikelompokkan per lokasi

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