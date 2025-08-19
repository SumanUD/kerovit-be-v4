@extends('adminlte::page')

@section('title', 'All Blogs')

@section('content_header')
    <h1>All Blogs</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('blogs.create') }}" class="btn btn-primary mb-3">+ Add New Blog</a>

    <div class="card">
        <div class="card-body table-responsive">
            <table id="blogsTable" class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Published Date</th>
                        <th>Is Popular</th>
                        <th>Banner</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blogs as $blog)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $blog->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($blog->published_date)->format('d M Y') }}</td>
                            <td>
                                @if($blog->is_popular)
                                    ✅
                                @else
                                    ❌
                                @endif
                            </td>

                            <td>
                                @if($blog->banner_image)
                                    <img src="{{ asset('storage/' . $blog->banner_image) }}" width="100">
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure to delete this blog?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted">No blogs found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@stop

@section('js')
    {{-- jQuery + DataTables --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#blogsTable').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                order: [[ 0, "asc" ]]
            });
        });
    </script>
@stop
