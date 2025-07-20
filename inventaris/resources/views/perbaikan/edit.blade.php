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
            <select name="kategori" id="kategori" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach (array_keys(config('subkategori.mapping')) as $kat)
                    <option value="{{ $kat }}" {{ (old('kategori', $perbaikan->kategori) == $kat) ? 'selected' : '' }}>{{ $kat }}</option>
                @endforeach
            </select>
        </div>

        {{-- Sub Kategori --}}
        <div class="mb-3">
            <label for="sub_kategori" class="form-label">Sub Kategori</label>
            <select name="sub_kategori" id="sub_kategori" class="form-select" required>
                <option value="">-- Pilih Sub Kategori --</option>
                @foreach ($subKategoriList as $sub)
                    <option value="{{ $sub }}" {{ old('sub_kategori', $perbaikan->sub_kategori) == $sub ? 'selected' : '' }}>
                        {{ $sub }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Detail --}}
        <div class="mb-3">
            <label for="detail_kerusakan" class="form-label">Detail Perbaikan</label>
            <input type="text" name="detail_kerusakan" id="detail_kerusakan" class="form-control" value="{{ old('detail_kerusakan', $perbaikan->detail_kerusakan) }}" required>
        </div>

        {{-- Komponen --}}
        <div class="mb-3">
            <label for="komponen" class="form-label">Komponen (Opsional)</label>
            <input type="text" name="komponen" id="komponen" class="form-control" value="{{ old('komponen', $perbaikan->komponen) }}">
        </div>

        {{-- Jumlah --}}
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" value="{{ old('jumlah', $perbaikan->jumlah) }}" required>
        </div>

        {{-- Satuan --}}
        <div class="mb-3">
            <label for="satuan" class="form-label">Satuan</label>
            <input type="text" name="satuan" id="satuan" class="form-control" value="{{ old('satuan', $perbaikan->satuan) }}" required>
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
                        <img src="{{ asset('storage/'.$perbaikan->foto_kerusakan) }}" width="80">
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
                        <img src="{{ asset('storage/'.$perbaikan->foto_nota) }}" width="80">
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const kategoriSelect = document.getElementById('kategori');
    const subKategoriSelect = document.getElementById('sub_kategori');

    function updateSubKategoriOptions(kategori) {
        subKategoriSelect.innerHTML = '<option value="">-- Pilih Sub Kategori --</option>';
        if (!kategori) return;

        const url = `/api/subkategori/${encodeURIComponent(kategori)}`;
        fetch(url)
            .then(r => r.json())
            .then(data => {
                data.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item;
                    opt.textContent = item;
                    subKategoriSelect.appendChild(opt);
                });
            })
            .catch(err => console.error('Gagal ambil subkategori:', err));
    }

    kategoriSelect.addEventListener('change', function () {
        updateSubKategoriOptions(this.value);
    });
});
</script>
@endpush
