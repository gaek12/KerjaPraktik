<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Perbaikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PerbaikanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Perbaikan::with('kendaraan')->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('kendaraan', function ($q) use ($search) {
                $q->where('nomor_polisi', 'like', "%{$search}%")
                ->orWhere('merk', 'like', "%{$search}%")
                ->orWhere('tipe', 'like', "%{$search}%");
            })
            ->orWhere('nama_bengkel', 'like', "%{$search}%")
            ->orWhere('kategori', 'like', "%{$search}%")
            ->orWhere('detail_perbaikan', 'like', "%{$search}%");
        }

        $perbaikan = $query->get();

        return view('perbaikan.index')->with('perbaikan',$perbaikan);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kendaraan = Kendaraan::all();
        return view('perbaikan.create')->with('kendaraan',$kendaraan);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'nama_bengkel' => 'required|string|max:255',
            'kategori' => 'required|string',
            'detail_perbaikan' => 'required|string',
            'jumlah' => 'required|integer|min:1',
            'harga_per_pcs' => 'required|integer|min:0',
            'foto_kerusakan' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'foto_nota' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'tanggal_perbaikan' => 'required|date',
            'tanggal_selesai' => 'nullable|date'
        ]);

        // Simpan foto kerusakan jika diunggah
        if ($request->hasFile('foto_kerusakan')) {
            $fotoKerusakan = $request->file('foto_kerusakan')->store('uploads/kerusakan', 'public');
            $validated['foto_kerusakan'] = $fotoKerusakan;
        }

        // Simpan foto nota jika diunggah
        if ($request->hasFile('foto_nota')) {
            $fotoNota = $request->file('foto_nota')->store('uploads/nota', 'public');
            $validated['foto_nota'] = $fotoNota;
        }

        // Simpan ke database
        Perbaikan::create($validated);

        // Redirect dengan pesan sukses
        return redirect()->to(route('perbaikan.index') . '#perbaikan')->with('success', 'Data perbaikan berhasil disimpan.');
    }

    public function show(Perbaikan $perbaikan)
    {
        //
    }

    public function edit(Perbaikan $perbaikan)
    {
        $kendaraan = Kendaraan::all();
        return view('perbaikan.edit')->with('perbaikan',$perbaikan)->with('kendaraan',$kendaraan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Perbaikan $perbaikan)
    {
        $validated = $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'nama_bengkel' => 'required|string|max:255',
            'kategori' => 'required',
            'detail_perbaikan' => 'required|string',
            'jumlah' => 'required|integer|min:1',
            'harga_per_pcs' => 'required|integer|min:0',
            'foto_kerusakan' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'foto_nota' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'tanggal_perbaikan' => 'required|date',
            'tanggal_selesai' => 'nullable|date'
        ]);

        // Handle foto kerusakan jika diupload ulang
        if ($request->hasFile('foto_kerusakan')) {
            if ($perbaikan->foto_kerusakan && Storage::disk('public')->exists($perbaikan->foto_kerusakan)) {
                Storage::disk('public')->delete($perbaikan->foto_kerusakan);
            }
            $validated['foto_kerusakan'] = $request->file('foto_kerusakan')->store('uploads/kerusakan', 'public');
        }

        // Handle foto nota jika diupload ulang
        if ($request->hasFile('foto_nota')) {
            if ($perbaikan->foto_nota && Storage::disk('public')->exists($perbaikan->foto_nota)) {
                Storage::disk('public')->delete($perbaikan->foto_nota);
            }
            $validated['foto_nota'] = $request->file('foto_nota')->store('uploads/nota', 'public');
        }

        $perbaikan->update($validated);

        return redirect()->to(route('perbaikan.index') . '#perbaikan')->with('success', 'Data perbaikan berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Perbaikan $perbaikan)
    {
        // Hapus file foto kerusakan jika ada
        if ($perbaikan->foto_kerusakan && Storage::disk('public')->exists($perbaikan->foto_kerusakan)) {
            Storage::disk('public')->delete($perbaikan->foto_kerusakan);
        }

        // Hapus file foto nota jika ada
        if ($perbaikan->foto_nota && Storage::disk('public')->exists($perbaikan->foto_nota)) {
            Storage::disk('public')->delete($perbaikan->foto_nota);
        }

        // Hapus data dari database
        $perbaikan->delete();

        return redirect()->route('perbaikan.index')
            ->with('success', 'Data perbaikan berhasil dihapus beserta fotonya.');
    }

    public function cetak(Request $request)
    {
        $request->validate([
            'bulan' => 'required|numeric',
            'tahun' => 'required|numeric',
        ]);

        $bulan = intval($request->input('bulan')); // Pastikan integer
        $tahun = intval($request->input('tahun'));

        $perbaikan = Perbaikan::with('kendaraan')
            ->whereMonth('tanggal_perbaikan', $bulan)
            ->whereYear('tanggal_perbaikan', $tahun)
            ->latest()
            ->get();

        return view('perbaikan.cetak', compact('perbaikan'));
    }
}
