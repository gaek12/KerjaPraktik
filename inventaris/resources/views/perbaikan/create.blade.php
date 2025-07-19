@extends('layout.main')

@section('title', 'Tambah Data Perbaikan')

@section('content')
<div class="container" id="tambahperbaikan" style="max-width: 700px;">
    <h2 class="mb-4">Tambah Data Perbaikan</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('perbaikan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Kendaraan + Nama Bengkel --}}
        <div class="row mb-3">
            <div class="col-lg-12">
                <label for="kendaraan_id" class="form-label">Kendaraan</label>
                <select name="kendaraan_id" id="kendaraan_id" class="form-select" required>
                    <option value="">-- Pilih Kendaraan --</option>
                    @foreach ($kendaraan as $k)
                        <option value="{{ $k->id }}" {{ old('kendaraan_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nomor_polisi }} - {{ $k->tipe }} - {{ $k->merk }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12 mt-3">
                <label for="nama_bengkel" class="form-label">Nama Bengkel</label>
                <input type="text" name="nama_bengkel" id="nama_bengkel" class="form-control" value="{{ old('nama_bengkel') }}" required>
            </div>
        </div>

        {{-- Kategori dan Subkategori --}}
        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <select name="kategori" id="kategori" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach (array_keys(config('subkategori.mapping')) as $kat)
                    <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="sub_kategori" class="form-label">Sub Kategori (Inisial)</label>
            <select name="sub_kategori" id="sub_kategori" class="form-select" required>
                <option value="">-- Pilih Sub Kategori --</option>
            </select>
        </div>

        {{-- Detail --}}
        <div class="mb-3">
            <label for="detail_kerusakan" class="form-label">Detail Perbaikan</label>
            <input type="text" name="detail_kerusakan" id="detail_kerusakan" class="form-control" value="{{ old('detail_kerusakan') }}" required>
        </div>

        <div class="mb-3">
            <label for="komponen" class="form-label">Komponen (Opsional)</label>
            <input type="text" name="komponen" id="komponen" class="form-control" value="{{ old('komponen') }}">
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" value="{{ old('jumlah') }}" required>
        </div>

        <div class="mb-3">
            <label for="satuan" class="form-label">Satuan</label>
            <input type="text" name="satuan" id="satuan" class="form-control" value="{{ old('satuan', 'pcs') }}" required>
        </div>

        <div class="mb-3">
            <label for="harga_per_pcs" class="form-label">Harga per pcs (Rp)</label>
            <input type="number" name="harga_per_pcs" id="harga_per_pcs" class="form-control" min="0" value="{{ old('harga_per_pcs') }}" required>
        </div>

        {{-- Foto --}}
        <div class="mb-3">
            <label for="foto_kerusakan" class="form-label">Foto Kerusakan</label>
            <input type="file" name="foto_kerusakan" id="foto_kerusakan" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            <label for="foto_nota" class="form-label">Foto Nota</label>
            <input type="file" name="foto_nota" id="foto_nota" class="form-control" accept="image/*">
        </div>

        {{-- Tanggal --}}
        <div class="mb-3">
            <label for="tanggal_perbaikan" class="form-label">Tanggal Perbaikan</label>
            <input type="date" name="tanggal_perbaikan" id="tanggal_perbaikan" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control">
        </div>

        <div class="d-flex flex-wrap gap-2 mt-3">
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('perbaikan.index') }}#perbaikan" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

@php
    $subKategoriMap = config('subkategori.mapping');
@endphp

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const subKategoriMap = @json($subKategoriMap);
        const kategoriSelect = document.getElementById('kategori');
        const subKategoriSelect = document.getElementById('sub_kategori');

        const oldKategori = @json(old('kategori'));
        const oldSubKategori = @json(old('sub_kategori'));

        const normalize = str => str?.trim().replace(/\s+/g, ' ').toLowerCase();

        function updateSubKategoriOptions(selectedKategori, selectedSub = null) {
            const normalized = normalize(selectedKategori);
            const keyMatch = Object.keys(subKategoriMap).find(k => normalize(k) === normalized);
            subKategoriSelect.innerHTML = '<option value="">-- Pilih Sub Kategori --</option>';

            if (!keyMatch) {
                console.warn("⚠️ Kategori tidak ditemukan dalam mapping:", selectedKategori);
                return;
            }

            subKategoriMap[keyMatch].forEach(item => {
                const option = document.createElement('option');
                option.value = item;
                option.textContent = item;
                if (item === selectedSub) {
                    option.selected = true;
                }
                subKategoriSelect.appendChild(option);
            });

            console.log(`✅ Subkategori untuk [${keyMatch}] diupdate. Total: ${subKategoriMap[keyMatch].length}`);
        }

        kategoriSelect.addEventListener('change', function () {
            updateSubKategoriOptions(this.value);
        });

        // 🚀 Force pilih default kategori jika ada old value
        if (oldKategori) {
            // Set value secara paksa
            kategoriSelect.value = oldKategori;
            console.log("📌 Inisialisasi kategori dari old():", kategoriSelect.value);
            updateSubKategoriOptions(kategoriSelect.value, oldSubKategori);
        } else {
            console.warn("⛔ Tidak ada kategori aktif saat initial load.");
        }
    });
</script>


@endsection
