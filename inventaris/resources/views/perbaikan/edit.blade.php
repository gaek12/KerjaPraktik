@extends('layout.main')

@section('title', 'Edit Data Perbaikan')

@section('content')
<div class="container" id="editperbaikan" style="max-width: 700px;">
    <h2 class="mb-4">Edit Data Perbaikan</h2>

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

    <form action="{{ route('perbaikan.update', $perbaikan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Kendaraan + Nama Bengkel --}}
        <div class="row mb-3">
            <div class="col-lg-12">
                <label for="kendaraan_id" class="form-label">Kendaraan</label>
                <select name="kendaraan_id" id="kendaraan_id" class="form-select" required>
                    <option value="">-- Pilih Kendaraan --</option>
                    @foreach ($kendaraan as $k)
                        <option value="{{ $k->id }}" {{ $perbaikan->kendaraan_id == $k->id ? 'selected' : '' }}>
                            {{ $k->nomor_polisi }} - {{ $k->tipe }} - {{ $k->merk }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12 mt-3">
                <label for="nama_bengkel" class="form-label">Nama Bengkel</label>
                <input type="text" name="nama_bengkel" id="nama_bengkel" class="form-control" value="{{ old('nama_bengkel', $perbaikan->nama_bengkel) }}" required>
            </div>
        </div>

        {{-- Kategori --}}
        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <input type="text" name="kategori" id="kategori" class="form-control" value="{{ old('kategori', $perbaikan->kategori) }}" required>
        </div>

        <div class="mb-3">
            <label for="detail_perbaikan" class="form-label">Detail Perbaikan</label>
            <input type="text" name="detail_perbaikan" id="detail_perbaikan" class="form-control" value="{{ old('detail_perbaikan', $perbaikan->detail_perbaikan) }}" required>
        </div>

        {{-- Jumlah --}}
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah (pcs)</label>
            <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" value="{{ old('jumlah', $perbaikan->jumlah) }}" required>
        </div>

        {{-- Harga --}}
        <div class="mb-3">
            <label for="harga_per_pcs" class="form-label">Harga per pcs (Rp)</label>
            <input type="number" name="harga_per_pcs" id="harga_per_pcs" class="form-control" min="0" value="{{ old('harga_per_pcs', $perbaikan->harga_per_pcs) }}" required>
        </div>

        {{-- Foto Kerusakan --}}
        <div class="mb-3">
            <label for="foto_kerusakan" class="form-label">Foto Kerusakan</label>
            @if ($perbaikan->foto_kerusakan)
                <div class="mb-2">
                    <a href="{{ asset('storage/'.$perbaikan->foto_kerusakan) }}" target="_blank">
                        <img src="{{ asset('storage/'.$perbaikan->foto_kerusakan) }}" width="80" style="border-radius: 5px; object-fit: cover;">
                    </a>
                </div>
            @endif
            <input type="file" name="foto_kerusakan" id="foto_kerusakan" class="form-control" accept="image/*">
        </div>

        {{-- Foto Nota --}}
        <div class="mb-3">
            <label for="foto_nota" class="form-label">Foto Nota</label>
            @if ($perbaikan->foto_nota)
                <div class="mb-2">
                    <a href="{{ asset('storage/'.$perbaikan->foto_nota) }}" target="_blank">
                        <img src="{{ asset('storage/'.$perbaikan->foto_nota) }}" width="80" style="border-radius: 5px; object-fit: cover;">
                    </a>
                </div>
            @endif
            <input type="file" name="foto_nota" id="foto_nota" class="form-control" accept="image/*">
        </div>

        {{-- Tanggal --}}
        <div class="mb-3">
            <label for="tanggal_perbaikan" class="form-label">Tanggal Perbaikan</label>
            <input type="date" name="tanggal_perbaikan" id="tanggal_perbaikan" class="form-control" value="{{ old('tanggal_perbaikan', $perbaikan->tanggal_perbaikan) }}">
        </div>

        <div class="mb-3">
            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai', $perbaikan->tanggal_selesai) }}">
        </div>

        <div class="d-flex flex-wrap gap-2 mt-3">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('perbaikan.index') }}#perbaikan" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
