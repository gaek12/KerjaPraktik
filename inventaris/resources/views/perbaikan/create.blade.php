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

        {{-- Kategori --}}
        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <input type="text" name="kategori" id="kategori" class="form-control" value="{{ old('kategori') }}" required>
        </div>

         <div class="mb-3">
            <label for="detail_perbaikan" class="form-label">Detail Perbaikan</label>
            <input type="text" name="detail_perbaikan" id="detail_perbaikan" class="form-control" value="{{ old('detail_perbaikan') }}" required>
        </div>

        {{-- Jumlah --}}
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah (pcs)</label>
            <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" value="{{ old('jumlah') }}" required>
        </div>

        {{-- Harga --}}
        <div class="mb-3">
            <label for="harga_per_pcs" class="form-label">Harga per pcs (Rp)</label>
            <input type="number" name="harga_per_pcs" id="harga_per_pcs" class="form-control" min="0" value="{{ old('harga_per_pcs') }}" required>
        </div>

        {{-- Status + Foto Kerusakan --}}
        <div class="row mb-3">
            <div class="col-md-12 mt-3">
                <label for="foto_kerusakan" class="form-label">Foto Kerusakan</label>
                <input type="file" name="foto_kerusakan" id="foto_kerusakan" class="form-control" accept="image/*">
            </div>
        </div>

        {{-- Foto Nota --}}
        <div class="mb-3">
            <label for="foto_nota" class="form-label">Foto Nota</label>
            <input type="file" name="foto_nota" id="foto_nota" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            <label for="tanggal_perbaikan" class="form-label">Tanggal Pebaikan</label>
            <input type="date" name="tanggal_perbaikan" id="tanggal_perbaikan" class="form-control">
        </div>

        <div class="mb-3">
            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" >
        </div>

        <div class="d-flex flex-wrap gap-2 mt-3">
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('perbaikan.index') }}#perbaikan" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
