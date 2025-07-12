@extends('layout.main')

@section('title','Dashboard')

@section('content')
<div class="container mt-4" id="index">
    <h1 class="mb-4">Dashboard Perbaikan Kendaraan Bulan Ini</h1>

    <!-- 🔽 Filter Bulan & Tahun -->
    <form method="GET" action="{{ route('dashboard') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <select name="bulan" class="form-control">
                @foreach(range(1, 12) as $bulan)
                    <option value="{{ $bulan < 10 ? '0' . $bulan : $bulan }}" {{ $bulanDipilih == $bulan ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="tahun" class="form-control">
                @for ($i = now()->year; $i >= now()->year - 5; $i--)
                    <option value="{{ $i }}" {{ $tahunDipilih == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary" type="submit">Tampilkan</button>
        </div>
    </form>

    <!-- Grafik -->
    <canvas id="grafikPerbaikan" height="100"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('grafikPerbaikan').getContext('2d');
    const grafikPerbaikan = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($label) !!},
            datasets: [{
                label: 'Jumlah Perbaikan Kendaraan',
                data: {!! json_encode($jumlahPerbaikan) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.7)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true, position: 'top' }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0,
                    title: { display: true, text: 'Jumlah Perbaikan' }
                },
                x: {
                    title: { display: true, text: 'Nama Kendaraan' }
                }
            }
        }
    });
</script>
@endsection
