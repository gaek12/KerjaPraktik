<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Perbaikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PerbaikanController extends Controller
{
    public function index(Request $request)
    {
        $query = Perbaikan::with('kendaraan')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('kendaraan', function ($q) use ($search) {
                $q->where('nomor_polisi', 'like', "%{$search}%")
                    ->orWhere('merk', 'like', "%{$search}%")
                    ->orWhere('tipe', 'like', "%{$search}%");
            })->orWhere('nama_bengkel', 'like', "%{$search}%")
              ->orWhere('kategori', 'like', "%{$search}%")
              ->orWhere('sub_kategori', 'like', "%{$search}%")
              ->orWhere('detail_kerusakan', 'like', "%{$search}%");
        }

        $perbaikan = $query->get();

        return view('perbaikan.index', compact('perbaikan'));
    }

    public function create(Request $request)
    {
        $kendaraan = Kendaraan::all();
        $kategoriTerpilih = $request->get('kategori') ?? old('kategori');
        $subKategoriList = [];

        if ($kategoriTerpilih && isset(config('subkategori.mapping')[$kategoriTerpilih])) {
            $subKategoriList = config('subkategori.mapping')[$kategoriTerpilih];
        }

        return view('perbaikan.create', compact('kendaraan', 'kategoriTerpilih', 'subKategoriList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'nama_bengkel' => 'required|string|max:255',
            'kategori' => 'required|string',
            'sub_kategori' => 'required|string',
            'detail_kerusakan' => 'required|string',
            'komponen' => 'nullable|string',
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'required|string|max:10',
            'harga_per_pcs' => 'required|integer|min:0',
            'total_harga' => 'nullable|integer|min:0',
            'foto_kerusakan' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'foto_nota' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'tanggal_perbaikan' => 'required|date',
            'tanggal_selesai' => 'nullable|date'
        ]);

        $validated['total_harga'] = $validated['jumlah'] * $validated['harga_per_pcs'];

        if ($request->hasFile('foto_kerusakan')) {
            $validated['foto_kerusakan'] = $request->file('foto_kerusakan')->store('uploads/kerusakan', 'public');
        }

        if ($request->hasFile('foto_nota')) {
            $validated['foto_nota'] = $request->file('foto_nota')->store('uploads/nota', 'public');
        }

        Perbaikan::create($validated);

        return redirect()->to(route('perbaikan.index') . '#perbaikan')->with('success', 'Data perbaikan berhasil disimpan.');
    }

    public function show(Perbaikan $perbaikan)
    {
        return view('perbaikan.show', compact('perbaikan'));
    }

    public function edit(Perbaikan $perbaikan)
    {
        $kendaraan = Kendaraan::all();
        $kategoriTerpilih = $perbaikan->kategori;
        $subKategoriList = [];

        if ($kategoriTerpilih && isset(config('subkategori.mapping')[$kategoriTerpilih])) {
            $subKategoriList = config('subkategori.mapping')[$kategoriTerpilih];
        }

        return view('perbaikan.edit', compact('perbaikan', 'kendaraan', 'kategoriTerpilih', 'subKategoriList'));
    }

    public function update(Request $request, Perbaikan $perbaikan)
    {
        $validated = $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'nama_bengkel' => 'required|string|max:255',
            'kategori' => 'required|string',
            'sub_kategori' => 'required|string',
            'detail_kerusakan' => 'required|string',
            'komponen' => 'nullable|string',
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'required|string|max:10',
            'harga_per_pcs' => 'required|integer|min:0',
            'total_harga' => 'nullable|integer|min:0',
            'foto_kerusakan' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'foto_nota' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'tanggal_perbaikan' => 'required|date',
            'tanggal_selesai' => 'nullable|date'
        ]);

        $validated['total_harga'] = $validated['jumlah'] * $validated['harga_per_pcs'];

        if ($request->hasFile('foto_kerusakan')) {
            if ($perbaikan->foto_kerusakan && Storage::disk('public')->exists($perbaikan->foto_kerusakan)) {
                Storage::disk('public')->delete($perbaikan->foto_kerusakan);
            }
            $validated['foto_kerusakan'] = $request->file('foto_kerusakan')->store('uploads/kerusakan', 'public');
        }

        if ($request->hasFile('foto_nota')) {
            if ($perbaikan->foto_nota && Storage::disk('public')->exists($perbaikan->foto_nota)) {
                Storage::disk('public')->delete($perbaikan->foto_nota);
            }
            $validated['foto_nota'] = $request->file('foto_nota')->store('uploads/nota', 'public');
        }

        $perbaikan->update($validated);

        return redirect()->to(route('perbaikan.index') . '#perbaikan')->with('success', 'Data perbaikan berhasil diperbarui.');
    }

    public function destroy(Perbaikan $perbaikan)
    {
        if ($perbaikan->foto_kerusakan && Storage::disk('public')->exists($perbaikan->foto_kerusakan)) {
            Storage::disk('public')->delete($perbaikan->foto_kerusakan);
        }

        if ($perbaikan->foto_nota && Storage::disk('public')->exists($perbaikan->foto_nota)) {
            Storage::disk('public')->delete($perbaikan->foto_nota);
        }

        $perbaikan->delete();

        return redirect()->route('perbaikan.index')->with('success', 'Data perbaikan berhasil dihapus beserta fotonya.');
    }

    public function cetak(Request $request)
    {
        $request->validate([
            'bulan' => 'required|numeric',
            'tahun' => 'required|numeric',
        ]);

        $perbaikan = Perbaikan::with('kendaraan')
            ->whereMonth('tanggal_perbaikan', $request->bulan)
            ->whereYear('tanggal_perbaikan', $request->tahun)
            ->latest()
            ->get();

        return view('perbaikan.cetak', compact('perbaikan'));
    }
}
