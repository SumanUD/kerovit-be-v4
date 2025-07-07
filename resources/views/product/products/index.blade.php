@extends('adminlte::page')

@section('title', 'Products for ' . $range->name)

@section('content_header')
    <h1>Products in Range: {{ $range->name }}</h1>
@stop

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<a href="{{ route('ranges.products.create', $range->id) }}" class="btn btn-primary mb-3">+ Add New Product</a>

<div class="drag-hint mb-3">
    <i class="fas fa-arrows-alt text-muted"></i>
    <span>Drag the cards below to reorder products.</span>
</div>

<div class="accordion" id="productAccordion">
    @foreach($products as $product)
        <div class="card mb-3 sortable-row" data-id="{{ $product->id }}">
            <div class="card-header handle d-flex justify-content-between align-items-center" id="heading{{ $product->id }}">
                <div class="d-flex align-items-center">
                    <i class="fas fa-grip-vertical drag-icon mr-2"></i>
                    <button class="btn btn-link text-dark font-weight-bold p-0" type="button" data-toggle="collapse"
                        data-target="#collapse{{ $product->id }}" aria-expanded="false"
                        aria-controls="collapse{{ $product->id }}">
                        {{ $product->product_title }} ({{ $product->product_code }})
                    </button>
                </div>
                <div>
                    <a href="{{ route('ranges.products.edit', [$range->id, $product->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                    <a href="{{ route('products.variants.create', $product->id) }}" class="btn btn-sm btn-info">+ Add Variant</a>
                    <form action="{{ route('ranges.products.destroy', [$range->id, $product->id]) }}" method="POST"
                          class="d-inline" onsubmit="return confirm('Delete this product?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            </div>

            <div id="collapse{{ $product->id }}" class="collapse" aria-labelledby="heading{{ $product->id }}" data-parent="#productAccordion">
                <div class="card-body bg-white">
                    <div class="row mb-3">
                        <div class="col-md-3 text-center">
                            @if($product->product_picture)
                                <img src="{{ asset('storage/products/' . $product->product_picture) }}" alt="Image"
                                     class="img-fluid rounded shadow-sm border" style="max-height: 180px;">
                            @else
                                <span class="text-muted">No Image</span>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <p><strong>Product code:</strong> {{ $product->product_code }}</p>
                            
                           <p>Color:  <div style="width: 20px; height: 20px; border: 1px solid #ccc; border-radius: 4px; background-color: {{ $product->product_color_code }};">
                            </div></p>
                            <p><strong>Description:</strong> {{ $product->product_description }}</p>
                        </div>
                    </div>

                    @if($product->variants->count())
                        <hr>
                        <h5>Variants</h5>
                        <table class="table table-sm table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Code</th>
                                    <th>Title</th>
                                    <th>Color</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product->variants as $variant)
                                    <tr>
                                        <td>{{ $variant->product_code }}</td>
                                        <td>{{ $variant->product_title }}</td>
                                        <td>
                                            <div style="width: 20px; height: 20px; border: 1px solid #ccc; border-radius: 4px; background-color: {{ $variant->product_color_code }};">
                                            </div>
                                        </td>
                                        <td>

                                       
                                         @if($variant->product_picture)
                                            <img src="{{ asset('storage/products/' . $variant->product_picture) }}" alt="Image"
                                                class="img-fluid rounded shadow-sm border" style="max-height: 60px;">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                         </td>
                                        <td>
                                            <a href="{{ route('products.variants.edit', [$product->id, $variant->id]) }}"
                                               class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('products.variants.destroy', [$product->id, $variant->id]) }}"
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Delete this variant?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">No variants added.</p>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>

@stop

@push('css')
    <style>
        .handle {
            cursor: grab;
            user-select: none;
            background-color: #f8f9fa;
        }

        .sortable-row:hover {
            background-color: #fefefe;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        }

        .drag-icon {
            font-size: 1.1rem;
            color: #6c757d;
        }

        .drag-hint {
            font-size: 0.9rem;
            color: #666;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .ui-sortable-placeholder {
            height: 80px;
            background: #e9ecef;
            border: 2px dashed #adb5bd;
            visibility: visible !important;
        }

        .card {
            border-radius: 0.5rem;
        }

        .card-body {
            background: #fff;
        }
    </style>
@endpush

@push('js')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script>
        $(function () {
            $('#productAccordion').sortable({
                handle: '.handle',
                placeholder: 'ui-sortable-placeholder',
                update: function () {
                    let order = $(this).sortable('toArray', { attribute: 'data-id' });
                    $.ajax({
                        url: '{{ route('ranges.products.reorder', $range->id) }}',
                        method: 'POST',
                        data: {
                            order: order,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function () {
                            console.log('Product order updated');
                        }
                    });
                }
            }).disableSelection();
        });
    </script>
@endpush
