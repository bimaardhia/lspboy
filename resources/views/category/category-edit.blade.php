@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mt-5">

            <h2 class="mb-5">Edit Category: {{ $category->category_name }}</h2>

            @if ($errors->any())
                <div class="alert alert-danger col-md-6">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form  action="{{ url('category/'.$category->id.'/update') }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="col-md-6">
                    <label for="category_name" class="form-label">Category Name :</label>
                    <input type="text" class="form-control" id="category_name" name="category_name" value="{{ $category->category_name }}">
                </div>
                <div class="col-md-6 mt-3">
                    <button class="btn btn-success form-control">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
