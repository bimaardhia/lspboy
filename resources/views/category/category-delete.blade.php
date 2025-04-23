@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="alert alert-danger">
        <h4>Are you sure you want to delete the category "<strong>{{ $category->category_name }}</strong>"?</h4>
        <p>All items associated with this category will also be deleted.</p>
        <form method="POST" action="{{ url('category/'.$category->id.'/destroy') }}">
            @csrf
            @method('DELETE')

            <a href="{{ url('category') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
    </div>
</div>
@endsection
