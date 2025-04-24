@extends('layouts.app')
@section('content')
<div class="container">
    <h1 class="mt-5 text-center">Dashboard</h1>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card text-bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Today's Transaction Insights</h5> <!-- Judul diubah -->
                    <p class="card-text fs-3">{{ $todayTransactions }}</p> <!-- Menampilkan jumlah transaksi hari ini -->
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card text-bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Today's Revenue</h5>
                    <p class="card-text fs-3">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Revenue (Last 7 Days)</h5>
            <canvas id="transactionChart" height="50"></canvas>
        </div>
    </div>

    {{-- 5 transaksi terakhir --}}
    <div class="card mb-5">
        <div class="card-body" >
            <h5 class="card-title">Latest Transactions</h5>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($latestTransactions as $trx)
                        <tr>
                            <td>{{ $trx->id }}</td>
                            <td>{{ $trx->created_at->format('d M Y, H:i') }}</td>
                            <td>Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('transactionChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},  // Use chartLabels
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($chartValues) !!},  // Use chartValues
                borderColor: 'rgba(75, 192, 192, 1)',
                fill: false,
                tension: 0.3
            }]
        }
    });
</script>

@endpush
