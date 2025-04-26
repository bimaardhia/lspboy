@extends('layouts.app')

@section('content')
<div class="container mt-5">
    @if (Session::has('message'))
        <p class="alert alert-{{ Session::get('message_type', 'info') }}">{{ Session::get('message') }}</p>
    @endif
    <h2>Transaction Receipt</h2>

    <div class="card">
        <div class="card-body">
            <h5>Transaction ID: #{{ $transaction->id }}</h5>
            <p><strong>Date:</strong> {{ $transaction->created_at->format('d M Y H:i') }}</p>
            <p><strong>Customer:</strong> {{ $transaction->user->name }}</p>
            <ul class="list-group mb-3">
                <!-- Header -->
                <li class="list-group-item bg-light fw-bold">
                    <div class="row text-center">
                        <div class="col-6 text-start">Item Name</div>
                        <div class="col-2">Qty</div>
                        <div class="col-2">Price</div>
                        <div class="col-2">Subtotal</div>
                    </div>
                </li>

                <!-- Items -->
                @foreach ($transaction->details as $detail)
                    <li class="list-group-item">
                        <div class="row text-center align-items-center">
                            <div class="col-6 text-start">{{ $detail->item_name ?? 'Item Deleted' }}</div>
                            <div class="col-2">{{ $detail->quantity }}</div>
                            <div class="col-2">Rp {{ number_format($detail->price, 2) }}</div>
                            <div class="col-2">Rp {{ number_format($detail->subtotal, 2) }}</div>
                        </div>
                    </li>
                @endforeach

                <!-- Total -->
                <li class="list-group-item d-flex justify-content-between fw-bold">
                    Total <span>Rp {{ number_format($transaction->total, 2) }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    Paid <span>Rp {{ number_format($transaction->paid_amount, 2) }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    Change <span>Rp {{ number_format($transaction->paid_amount - $transaction->total, 2) }}</span>
                </li>
            </ul>

            <a href="{{ url('/transaction') }}" class="btn btn-primary mt-3">Back to Cart</a>
        </div>
    </div>
</div>
@endsection
