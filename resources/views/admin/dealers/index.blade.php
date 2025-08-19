@extends('adminlte::page')
@section('title', 'Dealers')

@section('content')

    <a href="{{ route('dealers.create') }}" class="btn btn-primary mb-3">Add Dealer</a>
    <table id="dealers-table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Dealer Code</th>
                <th>Name</th>
                <th>City</th>
                <th>Pincode</th>
                <th>Contact</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dealers as $dealer)
                <tr>
                    <td>{{ $dealer->dealercode }}</td>
                    <td>{{ $dealer->contactperson }}</td>
                    <td>{{ $dealer->city }}</td>
                    <td>{{ $dealer->pincode }}</td>
                    <td>{{ $dealer->contactnumber }}</td>
                    <td>
                        <a href="{{ route('dealers.edit', $dealer->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('dealers.destroy', $dealer->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection

@section('css')
    {{-- ✅ Same as Blogs page --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
@stop

@section('js')
    console.log("hi");
    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    {{-- ✅ Same as Blogs page --}}
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#dealers-table').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50, 100],
                order: [[0, 'asc']] // sort by Dealer Code
            });
        });
    </script>
@stop
