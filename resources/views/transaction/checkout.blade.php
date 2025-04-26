@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Checkout</h2>

    @if (Session::has('message'))
        <p class="alert alert-{{ Session::get('message_type', 'info') }}">{{ Session::get('message') }}</p>
    @endif

    <div class="card">
        <div class="card-body">
            <h4>Order Summary</h4>
            <ul class="list-group mb-3">
                <!-- Header -->
            <li class="list-group-item bg-light fw-bold">
                <div class="row text-center">
                    <div class="col-6 text-start">Item Name</div>
                    <div class="col-3">Qty</div>
                    <div class="col-3">Subtotal</div>
                </div>
            </li>

            <!-- Isi Cart -->
            @foreach ($cart_items as $item)
                <li class="list-group-item">
                    <div class="row text-center align-items-center">
                        <div class="col-6 text-start">{{ $item->item->item_name }}</div>
                        <div class="col-3">{{ $item->quantity }}</div>
                        <div class="col-3">Rp {{ number_format($item->quantity * $item->item->price, 2) }}</div>
                    </div>
                </li>
            @endforeach
                <li class="list-group-item d-flex justify-content-between fw-bold">
                    Total
                    <span>Rp {{ number_format($total, 2) }}</span>
                </li>
            </ul>

            <form method="POST" action="{{ url('/transaction/checkout') }}">
                @csrf
                <div class="mb-3">
                    <label for="paid_amount" class="form-label">Amount Received (Rp)</label>
                    <input type="number" name="paid_amount" id="paid_amount" class="form-control" required">
                    <input type="hidden" name="total" value="{{ $total }}">
                </div>
                <button type="submit" class="btn btn-success">Pay & Finish</button>
            </form>
        </div>
    </div>
</div>
@endsection
