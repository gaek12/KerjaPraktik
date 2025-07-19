@extends('layout.main')

@section('title','Riwayat Data Perbaikan')

@section('content')
<div class="container" id="perbaikan">
    <h2 class="mb-4">Riwayat Data Perbaikan</h2>

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
                    <th>Nomor Polisi</th>
                    <th>Merk</th>
                    <th>Tipe</th>
                    <th>Bengkel</th>
                    <th>Kategori</th>
                    <th>Sub Kategori</th>
                    <th>Detail</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Tgl Perbaikan</th>
                    <th>Tgl Selesai</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($perbaikan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kendaraan->nomor_polisi ?? '-' }}</td>
                        <td>{{ $item->kendaraan->merk ?? '-' }}</td>
                        <td>{{ $item->kendaraan->tipe ?? '-' }}</td>
                        <td>{{ $item->nama_bengkel }}</td>
                        <td>{{ $item->kategori }}</td>
                        <td>{{ $item->sub_kategori }}</td>
                        <td>{{ $item->detail_kerusakan }}</td>
                        <td>{{ $item->jumlah }} {{ $item->satuan }}</td>
                        <td>Rp{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_perbaikan)->format('d-m-Y') }}</td>
                        <td>{{ $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('d-m-Y') : '-' }}</td>
                        <td>
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
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-transparant" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v text-black"></i>
                                </button>
                                <ul class="dropdown-menu p-2" style="min-width: 180px;">
                                    @if(auth()->user()->role === 'admin')
                                        <li>
                                            <a class="dropdown-item" href="{{ route('perbaikan.edit', $item->id) }}#editperbaikan">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('perbaikan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus data perbaikan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-trash-alt me-1"></i> Hapus
                                                </button>
                                            </form>
                                        </li>
                                    @endif
                                    @if(auth()->user()->role === 'user')
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <button class="dropdown-item text-success" data-bs-toggle="modal" data-bs-target="#modalCetak{{ $item->id }}">
                                                <i class="fas fa-print me-1"></i> Cetak
                                            </button>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>

                    @if(auth()->user()->role === 'user')
                        <div class="modal fade" id="modalCetak{{ $item->id }}" tabindex="-1" aria-labelledby="modalCetakLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <form action="{{ route('perbaikan.cetak') }}" method="GET" target="_blank">
                                <div class="modal-header">
                                <h5 class="modal-title" id="modalCetakLabel{{ $item->id }}">Cetak Laporan Bulanan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-9 mb-3">
                                        <label class="form-label">Bulan</label>
                                        <select name="bulan" class="form-select" required>
                                            <option value="">Pilih Bulan</option>
                                            @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">{{ DateTime::createFromFormat('!m', $i)->format('F') }}</option>
                                            @endfor
                                        </select>
                                        </div>
                                        <div class="col-md-9 mb-3">
                                        <label class="form-label">Tahun</label>
                                        <select name="tahun" class="form-select" required>
                                            <option value="">Pilih Tahun</option>
                                            @for ($y = date('Y'); $y >= 2020; $y--)
                                            <option value="{{ $y }}">{{ $y }}</option>
                                            @endfor
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-print me-1"></i> Cetak
                                </button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </form>
                            </div>
                        </div>
                        </div>
                    @endif
                @empty
                    <tr>
                        <td colspan="14" class="text-center">Belum ada data perbaikan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
