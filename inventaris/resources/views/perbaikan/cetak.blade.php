<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Perbaikan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f2f2f2;
        }
        tfoot td {
            font-style: italic;
            text-align: center;
            padding-top: 10px;
        }
        @media print {
            body {
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <h2>Laporan Data Perbaikan</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Polisi</th>
                <th>Merk</th>
                <th>Tipe</th>
                <th>Bengkel</th>
                <th>Kategori</th>
                <th>Sub Kategori</th>
                <th>Komponen</th>
                <th>Detail</th>
                <th>Jumlah</th>
                <th>Harga/pcs</th>
                <th>Total</th>
                <th>Tgl Perbaikan</th>
                <th>Tgl Selesai</th>
            </tr>
        </thead>
        <tbody>
            @forelse($perbaikan as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->kendaraan->nomor_polisi ?? '-' }}</td>
                <td>{{ $item->kendaraan->merk ?? '-' }}</td>
                <td>{{ $item->kendaraan->tipe ?? '-' }}</td>
                <td>{{ $item->nama_bengkel }}</td>
                <td>{{ $item->kategori }}</td>
                <td>{{ $item->sub_kategori ?? '-' }}</td>
                <td>{{ $item->komponen ?? '-' }}</td>
                <td>{{ $item->detail_kerusakan }}</td>
                <td>{{ $item->jumlah }} {{ $item->satuan ?? 'pcs' }}</td>
                <td>Rp{{ number_format($item->harga_per_pcs, 0, ',', '.') }}</td>
                <td>Rp{{ number_format($item->harga_per_pcs * $item->jumlah, 0, ',', '.') }}</td>
                <td>{{ $item->tanggal_perbaikan ? \Carbon\Carbon::parse($item->tanggal_perbaikan)->format('d-m-Y') : '-' }}</td>
                <td>{{ $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('d-m-Y') : '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="14" style="text-align:center;">Tidak ada data perbaikan tersedia.</td>
            </tr>
            @endforelse
        </tbody>
        @if($perbaikan->count())
        <tfoot>
            <tr>
                <td colspan="14">Total Data: {{ $perbaikan->count() }} perbaikan</td>
            </tr>
        </tfoot>
        @endif
    </table>

    <script>
        window.addEventListener("load", function () {
            window.print();
        });
    </script>
</body>
</html>
