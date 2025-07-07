@extends('adminlte::page')

@section('title', 'Dealers')

@section('content_header')
    <h1>Dealers List</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{ route('dealers.create') }}" class="btn btn-primary mb-3">Add New Dealer</a>
            
            <!-- Table for Dealers List -->
            <table id="dealers-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Dealer Name</th>
                        <th>Pin Code</th>
                        <th>City</th>
                        <th>Phone</th>
                        <th>Contact Person</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- DataTables will populate this with AJAX -->
                </tbody>
            </table>
        </div>
    </div>
@stop


@section('css')
    {{-- DataTables and Buttons CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
@stop

@section('js')
    {{-- jQuery and DataTables --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    {{-- Buttons for export --}}
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable with export buttons
            $('#dealers-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dealers.index') }}",  // AJAX request to get data
                columns: [
                    { data: 'dealername', name: 'dealername' },
                    { data: 'pincode', name: 'pincode' },
                    { data: 'city', name: 'city' },
                    { data: 'phone', name: 'phone' },
                    { data: 'contactperson', name: 'contactperson' },
                    {
                        data: 'actions',  // Column for the actions (View, Edit, Delete)
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ],
                dom: 'Bfrtip', // Add buttons above the table
                buttons: [
                    {
                        extend: 'csv',
                        text: 'Download CSV',
                        className: 'btn btn-success',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4] // Columns to be included in the export
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'Download Excel',
                        className: 'btn btn-warning',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4] // Columns to be included in the export
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'Download PDF',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4] // Columns to be included in the export
                        }
                    }
                ]
            });
        });
    </script>
@stop
