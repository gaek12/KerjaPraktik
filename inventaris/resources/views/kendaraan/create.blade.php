@extends('layout.main')

@section('title','Tambah Kendaraan')

@section('content')
<div class="container" id="tambahkendaraan">
    <h2 class="mb-4">Tambah Kendaraan</h2>

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

    <form action="{{ route('kendaraan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Foto -->
        <div class="mb-3">
            <label for="foto" class="form-label">Foto Kendaraan</label>
            <input type="file" name="foto" id="fotoInput" class="form-control" accept="image/*" required>
            <div class="mt-3">
                <img id="previewFoto" src="#" alt="Preview Foto" style="display: none; max-height: 200px; border-radius: 8px;">
            </div>
        </div>

        <!-- Nomor Polisi -->
        <div class="mb-3">
            <label for="nomor_polisi" class="form-label">Nomor Polisi</label>
            <input type="text" name="nomor_polisi" class="form-control" value="{{ old('nomor_polisi') }}" required>
        </div>

        <!-- Tipe -->
        <div class="mb-3">
            <label for="tipe" class="form-label">Tipe Kendaraan</label>
            <input type="text" name="tipe" class="form-control" value="{{ old('tipe') }}" required>
        </div>

        <!-- Merk -->
        <div class="mb-3">
            <label for="merk" class="form-label">Merk</label>
            <input type="text" name="merk" class="form-control" value="{{ old('merk') }}" required>
        </div>

        <!-- Status -->
        <label for="status" class="form-label">Status</label>
        <div class="mb-3">
            <select name="status" class="form-control" required>
                <option value="aktif" selected>Aktif</option>
                <option value="servis">Servis</option>
                <option value="tidak_aktif">Tidak Aktif</option>
            </select>
        </div>
        <!-- Tombol -->
        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-end">
                <a href="{{ route('kendaraan.index') }}#kendaraan" class="btn btn-secondary px-4">Kembali</a>
                <button type="submit" class="btn btn-danger px-4">Simpan</button>
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
            } else {
                preview.src = '#';
                preview.style.display = 'none';
            }
        });
    </script>
@endpush
@endsection