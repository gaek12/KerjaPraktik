@extends('layout.main')

@section('title','Edit Kendaraan')

@section('content')
<div class="container" id="editkendaraan">
    <h2 class="mb-4">Edit Kendaraan</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oops!</strong> Ada kesalahan input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kendaraan.update', $kendaraan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Foto -->
        <div class="mb-3">
            <label for="foto" class="form-label">Foto Kendaraan</label>
            <input type="file" name="foto" id="fotoInput" class="form-control" accept="image/*">
            <div class="mt-3">
                <img id="previewFoto" src="{{ asset('uploads/kendaraan/'.$kendaraan->foto) }}" alt="Foto Kendaraan"
                     style="max-height: 200px; border-radius: 8px;">
            </div>
        </div>

        <!-- Nomor Polisi -->
        <div class="mb-3">
            <label for="nomor_polisi" class="form-label">Nomor Polisi</label>
            <input type="text" name="nomor_polisi" id="nomor_polisi" class="form-control"
                   value="{{ old('nomor_polisi', $kendaraan->nomor_polisi) }}" required>
        </div>

        <div class="mb-3">
            <label for="nomor_mesin" class="form-label">Nomor Mesin</label>
            <input type="text" name="nomor_mesin" id="nomor_mesin" class="form-control"
                   value="{{ old('nomor_mesin', $kendaraan->nomor_mesin) }}" required>
        </div>

        <div class="mb-3">
            <label for="nomor_stnk" class="form-label">Nomor Stnk</label>
            <input type="text" name="nomor_stnk" id="nomor_stnk" class="form-control"
                   value="{{ old('nomor_stnk', $kendaraan->nomor_stnk) }}" required>
        </div>

        <!-- Tipe -->
        <div class="mb-3">
            <label for="tipe" class="form-label">Tipe Kendaraan</label>
            <input type="text" name="tipe" class="form-control"
                   value="{{ old('tipe', $kendaraan->tipe) }}" required>
        </div>

        <!-- Merk -->
        <div class="mb-3">
            <label for="merk" class="form-label">Merk</label>
            <input type="text" name="merk" class="form-control"
                   value="{{ old('merk', $kendaraan->merk) }}" required>
        </div>

        <!-- Status -->
        <label for="status" class="form-label">Status</label>
        <div class="mb-3">
            <select name="status" class="form-control" required>
                <option value="aktif" {{ $kendaraan->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="perbaikan" {{ $kendaraan->status == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
            </select>
        </div>

        <!-- Tombol -->
        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-end mt-3">
                <a href="{{ route('kendaraan.index') }}#kendaraan" class="btn btn-secondary px-4">Kembali</a>
                <button type="submit" class="btn btn-success px-4">Update</button>
            </div>
        </div>
    </form>
</div>
@push('scripts')
<script>
    document.getElementById('fotoInput').addEventListener('change', function (e) {
        const input = e.target;
        const preview = document.getElementById('previewFoto');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        }
    });
</script>
@endpush
@endsection
