@extends('adminlte::page')

@section('title', 'Contact Messages')

@section('content_header')
    <h1>Contact Messages</h1>
@stop


<style>
    .cke_notifications_area {
        display: none;
    }
    .main-sidebar{
        position: fixed !important;
    }
</style>

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <table id="messages-table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $message->name }}</td>
                            <td>{{ $message->email }}</td>
                            <td>{{ $message->phone }}</td>
                            <td>{{ $message->state }}</td>
                            <td>{{ $message->city }}</td>
                            <td>{{ $message->message }}</td>
                            <td>{{ $message->created_at->format('d M Y') }}</td>
                            <td>
                                <form action="{{ route('contact-messages.destroy', $message->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this message?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted">No messages found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#messages-table').DataTable();
            });
    </script>
@stop
