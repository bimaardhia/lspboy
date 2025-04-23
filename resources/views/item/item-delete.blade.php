@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="alert alert-danger">
        <h4>Are you sure you want to delete the item "<strong>{{ $item->item_name }}</strong>"?</h4>
        <p>This action cannot be undone.</p>
        <form method="POST" action="{{ url('item/'.$item->id.'/destroy') }}">
            @csrf
            @method('DELETE')

            <a href="{{ url('item') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
    </div>
</div>
@endsection
