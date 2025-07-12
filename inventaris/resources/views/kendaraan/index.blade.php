@extends('layout.main')

@section('title','Kendaraan')

@section('content')
<div class="container" id="kendaraan">
    <h2 class="mb-4">Daftar Kendaraan</h2>

    <!-- Search Form -->
    <div class="row mb-3">
        <div class="col-md-6">
            <form action="{{ route('kendaraan.index') }}#kendaraan" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control"
                        placeholder="Pencarian....."
                        value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if (request('search'))
        <div class="alert alert-info mt-2">
            Hasil pencarian untuk: <strong>{{ request('search') }}</strong>
            <a href="{{ route('kendaraan.index') }}#kendaraan" class="btn btn-sm btn-link">Reset</a>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nomor Polisi</th>
                    <th>Merk</th>
                    <th>Tipe</th>
                    <th>Status</th>
                    @if(auth()->user()->role === 'admin')
                        <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($kendaraan as $item)
                    <tr>
                        <td class="text-center align-middle px-3">{{ $loop->iteration }}</td>
                        <td class="text-center">
                            <img src="{{ asset('uploads/kendaraan/'.$item->foto) }}" width="100" height="70" style="object-fit: cover; border-radius: 5px;">
                        </td>
                        <td class="text-center align-middle px-3">{{ $item->nomor_polisi }}</td>
                        <td class="text-center align-middle px-3">{{ $item->merk }}</td>
                        <td class="text-center align-middle px-3">{{ $item->tipe }}</td>
                        <td class="text-center align-middle px-3">
                            @if ($item->status == 'aktif')
                                <span class="text-success">Aktif</span>
                            @elseif ($item->status == 'Perbaikan')
                                <span class="text-danger">Perbaikan</span>
                            @endif
                        </td>
                        @if(auth()->user()->role === 'admin')
                            <td class="text-text-center align-middle px-3">
                                <a href="{{ route('kendaraan.edit', $item->id) }}#editkendaraan" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('kendaraan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin hapus kendaraan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data kendaraan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
