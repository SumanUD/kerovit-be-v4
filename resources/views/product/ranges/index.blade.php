@extends('adminlte::page')

@section('title', 'Ranges for ' . $category->name)

@section('content_header')
<h1>Ranges under Category: {{ $category->name }}</h1>
@stop

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<a href="{{ route('categories.index') }}" class="btn btn-secondary mb-3">Back to Categories</a>
<a href="{{ route('categories.ranges.create', $category->id) }}" class="btn btn-primary mb-3">
    + Add New Range
</a>


<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="range-table">
                <thead class="thead-dark">
                    <tr>
                        <th style="width: 40px;"></th>
                        <th>Thumbnail</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th style="width: 130px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="sortable">
                    @foreach($ranges as $range)
                        <tr data-id="{{ $range->id }}" class="sortable-row">
                            <td class="text-center handle"><i class="fas fa-bars text-muted"></i></td>
                            <td>
                                @if($range->thumnbnail_image)
                                    <img src="{{ asset('storage/' . $range->thumnbnail_image) }}" alt="Thumbnail" width="60" height="60" class="rounded">
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>{{ $range->name }}</td>
                            <td>{{ $range->description }}</td>
                            <td>
                                <a href="{{ route('categories.ranges.edit', [$category->id, $range->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                                <a href="{{ route('ranges.products.index', $range->id) }}" class="btn btn-sm btn-info ml-1">See Products</a>
                                                            
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@push('css')
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
        .sortable-row:hover {
            background-color: #f9f9f9;
        }

        .handle {
            cursor: move;
        }

        .ui-sortable-placeholder {
            height: 48px;
            background: #f0f0f0;
            border: 2px dashed #ccc;
            visibility: visible !important;
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script>
        $(function () {
            $('#range-table').DataTable({
                paging: false,
                ordering: false,
                info: false
            });

            $('#sortable').sortable({
                handle: '.handle',
                placeholder: 'ui-sortable-placeholder',
                update: function () {
                    let order = $(this).sortable('toArray', { attribute: 'data-id' });
                    $.ajax({
                        url: '{{ route('categories.ranges.reorder', $category->id) }}',
                        method: 'POST',
                        data: {
                            order: order,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function () {
                            console.log('Order updated');
                        }
                    });
                }
            }).disableSelection();
        });
    </script>
@endpush