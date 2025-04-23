@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mt-5">
            <h1 class="text-center">Item List</h1>

            <div class="table-responsive mt-5">
                <a href="{{ url('/item/add') }}" class="btn btn-primary mb-3">Add New</a>

                @if (Session::has('message'))
                    <p class="alert alert-success">{{ Session::get('message') }}</p>
                @endif

                <form method="GET">
                    <div class="input-group mb-3">
                        <input type="text" name="item_key" value="{{ $item_key }}" class="form-control" placeholder="Search Item" aria-label="Search Item" aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                    </div>
                </form>

                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <th>#</th>
                                <th>Item Name</th>
                                <th>Stock</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Action</th>
                            </thead>
                            <tbody class="table-group-divider">
                                @foreach ($items as $item)
                                    <tr>
                                        <td class="align-middle">{{ ($items->currentpage()-1) * $items->perpage() + $loop->index + 1 }}</td>
                                        <td class="align-middle">{{ $item->item_name }}</td>
                                        <td class="align-middle">{{ $item->stock }}</td>
                                        <td class="align-middle">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="align-middle">{{ $item->category->category_name }}</td>
                                        <td class="align-middle">
                                            <a href="{{ url('item/'.$item->id.'/edit') }}">edit</a> |
                                            <a href="{{ url('item/'.$item->id.'/delete') }}">delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $items->links() }}                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
