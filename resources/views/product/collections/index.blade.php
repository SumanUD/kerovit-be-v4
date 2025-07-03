@extends('adminlte::page')

@section('title', 'Collections')

@section('content_header')
    <h1>Collections</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('collections.create') }}" class="btn btn-primary mb-3">Add New Collection</a>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped" id="collections-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Thumbnail</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($collections as $collection)
                        <tr>
                            <td>{{ $collection->name }}</td>
                            <td>{{ $collection->slug }}</td>
                            <td>
                                @if($collection->thumbnail_image)
                                    <img src="{{ asset('storage/' . $collection->thumbnail_image) }}" width="80">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('collections.edit', $collection) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ url('admin/collections/' . $collection->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('js')
<script>
    $(document).ready(function () {
        $('#collections-table').DataTable();
    });
</script>
@stop
