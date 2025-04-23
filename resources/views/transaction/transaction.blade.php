@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mt-5">
            <h1 class="text-center mb-5">Shopping Cart</h1>
            @if (Session::has('message'))
                <p class="alert alert-{{ Session::get('message_type', 'info') }}">{{ Session::get('message') }}</p> 
            @endif

            @if ($errors->any())
            @foreach ($errors->all() as $error)
                <p class="alert alert-danger ">{{ $error }}</p>
            @endforeach
            @endif
            <div class="mt-3">
                <h4>Add New Item to Cart</h4>
                <form action="{{ url('transaction/add') }}" method="POST">
                    @csrf
                    <div class="d-flex">
                        <select name="item_id" class="form-control" required>
                            <option value="">Select Item</option>
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}">{{ $item->item_name }} - {{ number_format($item->price, 2) }}</option>
                            @endforeach
                        </select>

                        <input type="number" name="quantity" min="1" class="form-control mx-2" style="width: 80px;" required placeholder="Quantity">

                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                    </div>
                </form>
            </div>

            <div class="table-responsive mt-3">

                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <th>#</th>
                                <th>Item Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </thead>
                            <tbody class="table-group-divider">
                                @foreach ($cart_items as $cart_item)
                               <tr>
                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                    <td class="align-middle">{{ $cart_item->item->item_name }}</td>
                                    <td class="align-middle">{{ number_format($cart_item->item->price, 2) }}</td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <form action="{{ url('transaction/'.$cart_item->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" name="quantity" value="{{ $cart_item->quantity }}" min="1" class="form-control mx-2" style="width: 70px;" onchange="this.form.submit()">
                                            </form>
                                        </div>
                                    </td>
                                    <td class="align-middle">{{ number_format($cart_item->quantity * $cart_item->item->price, 2) }}</td>
                                    <td class="align-middle">
                                        <form action="{{ url('transaction/'.$cart_item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                        </form>
                                    </td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-3">
                    <h3>Total : {{ number_format($cart_items->sum(function($item) { return $item->quantity * $item->item->price; }), 2) }}</h3>
                    <a href="{{ url('/transaction/checkout') }}" class="btn btn-success">Proceed to Checkout</a>
                </div>
            </div>
        </div>
    </div>
@endsection
