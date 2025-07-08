<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Perbaikan;
use Illuminate\Http\Request;

class PerbaikanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perbaikan = Perbaikan::with('kendaraan')->latest()->get();
        return view('perbaikan.index')->with('perbaikan', $perbaikan);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kendaraan = Kendaraan::all();
        return view('perbaikan.create')->with('kendaraan',$kendaraan);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'nama_bengkel' => 'required|string|max:255',
            'kategori' => 'required|in:ringan,berat',
            'detail_perbaikan' => 'required|string',
            'jumlah' => 'required|integer|min:1',
            'harga_per_pcs' => 'required|integer|min:0',
            'foto_kerusakan' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'foto_nota' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'tanggal_perbaikan' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_perbaikan'
        ]);

        // Upload foto jika ada
        if ($request->hasFile('foto_kerusakan')) {
            $validated['foto_kerusakan'] = $request->file('foto_kerusakan')->store('perbaikan/kerusakan', 'public');
        }

        if ($request->hasFile('foto_nota')) {
            $validated['foto_nota'] = $request->file('foto_nota')->store('perbaikan/nota', 'public');
        }

        Perbaikan::create($validated);

        return redirect()->route('perbaikan.index')->with('success', 'Data perbaikan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Perbaikan $perbaikan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Perbaikan $perbaikan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Perbaikan $perbaikan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Perbaikan $perbaikan)
    {
        //
    }
}
