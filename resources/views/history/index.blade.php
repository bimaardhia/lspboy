@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mt-5">
        <h1 class="text-center">Transaction History</h1>

        <div class="table-responsive mt-5">

            @if (Session::has('message'))
                <p class="alert alert-{{ Session::get('message_type', 'success') }}">{{ Session::get('message') }}</p>
            @endif

            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Transaction ID</th>
                                <th>Date</th>
                                <th>Total (Rp)</th>
                                <th>Paid</th>
                                <th>Change</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @foreach ($transactions as $transaction)
                            <tr>
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">{{ $transaction->id }}</td>
                                <td class="align-middle">{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                <td class="align-middle">Rp {{ number_format($transaction->total, 2) }}</td>
                                <td class="align-middle">Rp {{ number_format($transaction->paid_amount, 2) }}</td>
                                <td class="align-middle">Rp {{ number_format($transaction->change, 2) }}</td>
                                <td class="align-middle">
                                    <a href="{{ route('transaction.show', $transaction->id) }}">detail</a>
                                </td>
                            </tr>
                            @endforeach

                            @if ($transactions->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center">No transactions found.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    {{ $transactions->links() }}  
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
