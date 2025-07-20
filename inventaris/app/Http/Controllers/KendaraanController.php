<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class KendaraanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Kendaraan::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_polisi', 'like', "%$search%")
                ->orWhere('nomor_mesin', 'like', "%$search%")
                ->orWhere('nomor_stnk', 'like', "%$search%")
                ->orWhere('merk', 'like', "%$search%")
                ->orWhere('tipe', 'like', "%$search%");
            });
        }

        $kendaraan = $query->latest()->get();

        return view('kendaraan.index')->with('kendaraan', $kendaraan);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kendaraan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $val = $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'nomor_polisi' => 'required|max:255',
            'nomor_mesin' => 'required|max:255',
            'nomor_stnk' => 'required|max:255',
            'tipe' => 'required|max:255',
            'merk' => 'required|max:255',
        ]);

        $foto = $request->file('foto');
        $fotoName = Str::uuid() . '.' . $foto->getClientOriginalExtension();
        $foto->move(public_path('uploads/kendaraan'), $fotoName);

        // Simpan ke database
        Kendaraan::create([
            'foto' => $fotoName,
            'nomor_polisi' => $request->nomor_polisi,
            'nomor_mesin' => $request->nomor_mesin,
            'nomor_stnk' => $request->nomor_stnk,
            'tipe' => $request->tipe,
            'merk' => $request->merk,
            'status' => 'aktif',
        ]);

        return redirect()->to(route('kendaraan.index') . '#kendaraan')->with('success', 'Data kendaraan berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kendaraan $kendaraan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kendaraan $kendaraan)
    {
        return view('kendaraan.edit')->with('kendaraan',$kendaraan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kendaraan $kendaraan)
    {
        $request->validate([
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nomor_polisi' => 'required|max:255',
            'nomor_mesin' => 'required|max:255',
            'nomor_stnk' => 'required|max:255',
            'tipe' => 'required|max:255',
            'merk' => 'required|max:255',
            'status' => 'required|in:aktif,perbaikan',
        ]);

        // Cek jika ada file foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            $oldPath = public_path('uploads/kendaraan/' . $kendaraan->foto);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }

            // Upload foto baru
            $foto = $request->file('foto');
            $fotoName = Str::uuid() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('uploads/kendaraan'), $fotoName);

            $kendaraan->foto = $fotoName;
        }

        // Update data lainnya
        $kendaraan->nomor_polisi = $request->nomor_polisi;
        $kendaraan->nomor_mesin = $request->nomor_mesin;
        $kendaraan->nomor_stnk = $request->nomor_stnk;
        $kendaraan->tipe = $request->tipe;
        $kendaraan->merk = $request->merk;
        $kendaraan->status = $request->status;
        $kendaraan->save();

        return redirect()->to(route('kendaraan.index') . '#kendaraan')->with('success', 'Data kendaraan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kendaraan $kendaraan)
    {
        // Hapus file foto dari folder jika ada
        $fotoPath = public_path('uploads/kendaraan/' . $kendaraan->foto);

        if (File::exists($fotoPath)) {
            File::delete($fotoPath);
        }

        // Hapus data kendaraan dari database
        $kendaraan->delete();

        return redirect()->to(route('kendaraan.index') . '#kendaraan')->with('success', 'Data kendaraan berhasil dihapus');
    }
}
