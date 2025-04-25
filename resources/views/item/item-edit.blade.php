@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mt-5">
            <h2 class="mb-5">Edit Item: {{ $item->item_name }}</h2>

            @if ($errors->any())
                <div class="alert alert-danger col-md-6">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('item/'.$item->id.'/update') }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="col-md-6 mb-3">
                    <label for="item_name" class="form-label">Item Name:</label>
                    <input type="text" class="form-control" id="item_name" name="item_name" value="{{ $item->item_name }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="stock" class="form-label">Stock:</label>
                    <input type="number" class="form-control" id="stock" name="stock" value="{{ $item->stock }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label">Price:</label>
                    <input type="number" class="form-control" id="price" name="price" value="{{ $item->price }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="category_id" class="form-label">Category:</label>
                    <select name="category_id" id="category_id" class="form-control">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $item->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mt-3">
                    <button class="btn btn-success form-control">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
