@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mt-5">

            <h1 class="text-center">Category List </h1>
            <div class="table-responsive mt-5">
                <a href="{{ url('/category/add') }}" class="btn btn-primary mb-3">Add New</a>

                @if (Session::has('message'))
                    <p class="alert alert-success">{{ Session::get('message') }}</p>
                @endif

                <form method="GET">
                    <div class="input-group mb-3">
                        <input type="text" name="category_key" value="{{ $category_key }}" class="form-control" placeholder="Search Category" aria-label="Search Category" aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                    </div>
                </form>
                
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <th>#</th>
                                <th>Category</th>
                                <th>Action</th>
                            </thead>
                            <tbody class="table-group-divider">
                                @foreach ($categories as $category)
                                <tr>
                                    <td class="align-middle">{{ ($categories->currentpage()-1) * $categories->perpage() + $loop->index + 1 }}</td>
                                    <td class="align-middle">{{ $category->category_name }}</td>
                                    <td class="align-middle"><a href="{{ url('category/'.$category->id.'/detail') }}">detail</a> | <a href="{{ url('category/'.$category->id.'/edit') }}">edit</a> | <a href="{{ url('category/'.$category->id.'/delete') }}">delete</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
