<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Perbaikan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px;
            font-size: 12px;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            text-align: center;
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
                <th>Detail</th>
                <th>Jumlah</th>
                <th>Harga</th>
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
                <td>{{ $item->detail_perbaikan }}</td>
                <td>{{ $item->jumlah }} pcs</td>
                <td>Rp{{ number_format($item->harga_per_pcs * $item->jumlah, 0, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_perbaikan)->format('d-m-Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d-m-Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="11" style="text-align:center;">Tidak ada data perbaikan di bulan ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        window.addEventListener("load", function () {
            window.print();
        });
    </script>
</body>
</html>
