<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Models\Perbaikan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil nilai dari request, jika tidak ada pakai default saat ini
        $bulanDipilih = $request->input('bulan', now()->format('m'));
        $tahunDipilih = $request->input('tahun', now()->format('Y'));

        // Buat range tanggal awal dan akhir dari bulan & tahun yang dipilih
        $awal = Carbon::createFromDate($tahunDipilih, $bulanDipilih, 1)->startOfMonth();
        $akhir = Carbon::createFromDate($tahunDipilih, $bulanDipilih, 1)->endOfMonth();

        // Hitung jumlah perbaikan berdasarkan tanggal_perbaikan
        $dataKendaraan = Kendaraan::withCount(['perbaikans as jumlah_perbaikan' => function ($query) use ($awal, $akhir) {
            $query->whereBetween('tanggal_perbaikan', [$awal, $akhir]);
        }])->get();

        // Label: bisa nomor polisi, atau merk + tipe
        $label = $dataKendaraan->map(function ($item) {
            return $item->nomor_polisi ?? ($item->merk . ' ' . $item->tipe);
        })->toArray();

        $jumlahPerbaikan = $dataKendaraan->pluck('jumlah_perbaikan')->toArray();

        return view('dashboard', [
            'label' => $label,
            'jumlahPerbaikan' => $jumlahPerbaikan,
            'bulanDipilih' => $bulanDipilih,
            'tahunDipilih' => $tahunDipilih,
        ]);
    }
}
