@extends('adminlte::page')

@section('title', 'Categories')

@section('content_header')
    <h1>Categories</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Add New Category</a>

    <div class="card">
        <div class="card-body">
            <table id="category-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Collection</th>
                        <th>Slug</th>
                        <th>Thumbnail</th>
                        <th>Actions</th>
                        <th>Ranges</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->collection->name ?? '-' }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>
                                @if($category->thumbnail_image)
                                    <img src="{{ asset('storage/' . $category->thumbnail_image) }}" width="80">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this category?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('categories.ranges.index', $category->id) }}" class="btn btn-info btn-sm">View Ranges</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

{{-- Include CSS --}}
@push('css')
    {{-- DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

{{-- Include JS --}}
@push('js')
    {{-- jQuery (only if not already included in AdminLTE) --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- DataTables --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#category-table').DataTable({
                responsive: true,
                autoWidth: false
            });
        });
    </script>
@endpush
