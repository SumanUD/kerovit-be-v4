@extends('adminlte::page')

@section('title', 'Edit Product')

@section('content_header')
    <h1>Edit Product: {{ $product->product_title }}</h1>
@stop

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('ranges.products.update', [$range->id, $product->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card">
        <div class="card-body">

            <div class="form-group">
                <label for="product_code">Product Code <span class="text-danger">*</span></label>
                <input type="text" name="product_code" class="form-control @error('product_code') is-invalid @enderror" value="{{ old('product_code', $product->product_code) }}" required>
                @error('product_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="product_title">Product Title <span class="text-danger">*</span></label>
                <input type="text" name="product_title" class="form-control @error('product_title') is-invalid @enderror" value="{{ old('product_title', $product->product_title) }}" required>
                @error('product_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="product_picture">Product Picture</label><br>
                @if($product->product_picture)
                    <img src="{{ asset('storage/' . $product->product_picture) }}" alt="Image" width="80" class="mb-2">
                @endif
                <input type="file" name="product_picture" class="form-control-file @error('product_picture') is-invalid @enderror">
                @error('product_picture')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="series">Series</label>
                <input type="text" name="series" class="form-control @error('series') is-invalid @enderror" value="{{ old('series', $product->series) }}">
                @error('series')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="shape">Shape</label>
                <input type="text" name="shape" class="form-control @error('shape') is-invalid @enderror" value="{{ old('shape', $product->shape) }}">
                @error('shape')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="spray">Spray</label>
                <input type="text" name="spray" class="form-control @error('spray') is-invalid @enderror" value="{{ old('spray', $product->spray) }}">
                @error('spray')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="product_description">Description</label>
                <textarea name="product_description" class="form-control @error('product_description') is-invalid @enderror" rows="3">{{ old('product_description', $product->product_description) }}</textarea>
                @error('product_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="product_color_code">Color Code</label>
                <input type="text" name="product_color_code" class="form-control @error('product_color_code') is-invalid @enderror" value="{{ old('product_color_code', $product->product_color_code) }}">
                @error('product_color_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="product_feature">Features</label>
                <textarea name="product_feature" class="form-control @error('product_feature') is-invalid @enderror" rows="2">{{ old('product_feature', $product->product_feature) }}</textarea>
                @error('product_feature')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="product_installation_service_parts">Installation/Service Parts</label>
                <textarea name="product_installation_service_parts" class="form-control @error('product_installation_service_parts') is-invalid @enderror" rows="2">{{ old('product_installation_service_parts', $product->product_installation_service_parts) }}</textarea>
                @error('product_installation_service_parts')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="design_files">Design File</label><br>
                @if($product->design_files)
                    <a href="{{ asset('storage/' . $product->design_files) }}" target="_blank">View Existing File</a>
                @endif
                <input type="file" name="design_files" class="form-control-file @error('design_files') is-invalid @enderror">
                @error('design_files')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="additional_information">Additional Information</label>
                <textarea name="additional_information" class="form-control @error('additional_information') is-invalid @enderror" rows="2">{{ old('additional_information', $product->additional_information) }}</textarea>
                @error('additional_information')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn btn-success">Update Product</button>
            <a href="{{ route('ranges.products.index', $range->id) }}" class="btn btn-secondary">Cancel</a>

        </div>
    </div>
</form>

@stop
