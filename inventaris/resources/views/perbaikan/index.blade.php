@extends('layout.main')

@section('title','Data Perbaikan')

@section('content')
<div class="container" id="perbaikan">
    <h2 class="mb-4">Daftar Data Perbaikan</h2>

    <!-- Search Form -->
    <div class="row mb-3">
        <div class="col-md-6">
            <form action="{{ route('perbaikan.index') }}#perbaikan" method="GET">
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
            <a href="{{ route('perbaikan.index') }}#perbaikan" class="btn btn-sm btn-link">Reset</a>
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
                    <th>Kendaraan</th>
                    <th>Bengkel</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($perbaikan as $item)
                    <tr>
                        <td class="text-center align-middle px-3">{{ $loop->iteration }}</td>
                        <td class="text-center align-middle px-3">{{ $item->kendaraan->nomor_polisi ?? '-' }}</td>
                        <td class="text-center align-middle px-3">{{ $item->nama_bengkel }}</td>
                        <td class="text-center align-middle px-3 text-capitalize">{{ $item->kategori }}</td>
                        <td class="text-center align-middle px-3">{{ $item->jumlah }} pcs</td>
                        <td class="text-center align-middle px-3">Rp{{ number_format($item->harga_per_pcs * $item->jumlah, 0, ',', '.') }}</td>
                        <td class="text-center align-middle px-3">
                            @if ($item->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif ($item->status == 'proses')
                                <span class="badge bg-primary">Proses</span>
                            @else
                                <span class="badge bg-success">Selesai</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($item->foto_kerusakan || $item->foto_nota)
                                <div class="d-flex justify-content-center gap-2">
                                    @if ($item->foto_kerusakan)
                                        <a href="{{ asset('storage/'.$item->foto_kerusakan) }}" target="_blank" title="Foto Kerusakan">
                                            <img src="{{ asset('storage/'.$item->foto_kerusakan) }}" width="40" height="30" style="object-fit: cover; border-radius: 4px;">
                                        </a>
                                    @endif
                                    @if ($item->foto_nota)
                                        <a href="{{ asset('storage/'.$item->foto_nota) }}" target="_blank" title="Foto Nota">
                                            <img src="{{ asset('storage/'.$item->foto_nota) }}" width="40" height="30" style="object-fit: cover; border-radius: 4px;">
                                        </a>
                                    @endif
                                </div>
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-text-center align-middle px-3">
                            <a href="{{ route('perbaikan.edit', $item->id) }}#editperbaikan" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('perbaikan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin hapus data perbaikan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Belum ada data perbaikan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
