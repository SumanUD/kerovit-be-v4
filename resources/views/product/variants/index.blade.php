@extends('adminlte::page')

@section('title', 'Variants of ' . $product->product_title)

@section('content_header')
    <h1>Variants of Product: {{ $product->product_title }}</h1>
@stop

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<a href="{{ route('products.variants.create', $product->id) }}" class="btn btn-primary mb-3">
    + Add New Variant
</a>

<a href="{{ route('ranges.products.index', $product->range_id) }}" class="btn btn-secondary mb-3">
    ← Back to Products
</a>


<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="variant-table">
                <thead class="thead-dark">
                    <tr>
                        <th>Code</th>
                        <th>Title</th>
                        <th>Picture</th>
                        <th>Shape</th>
                        <th>Spray</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($variants as $variant)
                        <tr>
                            <td>{{ $variant->product_code }}</td>
                            <td>{{ $variant->product_title }}</td>
                            <td>
                                @if($variant->product_picture)
                                    <img src="{{ asset('storage/' . $variant->product_picture) }}" width="50">
                                @endif
                            </td>
                            <td>{{ $variant->shape }}</td>
                            <td>{{ $variant->spray }}</td>
                            <td>
                                <a href="{{ route('products.variants.edit', [$product->id, $variant->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('products.variants.destroy', [$product->id, $variant->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this variant?')">
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
</div>

@stop

@push('js')
<script>
    $(function () {
        $('#variant-table').DataTable({
            paging: true,
            ordering: true,
            info: true
        });
    });
</script>
@endpush
