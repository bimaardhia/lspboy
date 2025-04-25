@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mt-5">
        <h2 class="text-center">Category: {{ $category->category_name }}</h2>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item Name</th>
                        <th>Stock</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @forelse ($category->items as $index => $item)
                        <tr>
                            <td class="align-middle">{{ $index + 1 }}</td>
                            <td class="align-middle">{{ $item->item_name }}</td>
                            <td class="align-middle">{{ $item->stock }}</td>
                            <td class="align-middle">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">There are no items in this category yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
