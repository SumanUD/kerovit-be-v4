@extends('adminlte::page')

@section('title', 'Edit Variant')

@section('content_header')
    <h1>Edit Variant of Product: {{ $product->product_title }}</h1>
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

<form action="{{ route('products.variants.update', [$product->id, $variant->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div class="card">
        <div class="card-body">

            <div class="form-group">
                <label>Product Code <span class="text-danger">*</span></label>
                <input type="text" name="product_code" class="form-control @error('product_code') is-invalid @enderror" value="{{ old('product_code', $variant->product_code) }}" required>
                @error('product_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Product Title <span class="text-danger">*</span></label>
                <input type="text" name="product_title" class="form-control @error('product_title') is-invalid @enderror" value="{{ old('product_title', $variant->product_title) }}" required>
                @error('product_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Product Picture</label><br>
                @if($variant->product_picture)
                    <img src="{{ asset('storage/' . $variant->product_picture) }}" width="80" class="mb-2">
                @endif
                <input type="file" name="product_picture" class="form-control-file @error('product_picture') is-invalid @enderror">
                @error('product_picture') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Series</label>
                <input type="text" name="series" class="form-control @error('series') is-invalid @enderror" value="{{ old('series', $variant->series) }}">
                @error('series') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Shape</label>
                <input type="text" name="shape" class="form-control @error('shape') is-invalid @enderror" value="{{ old('shape', $variant->shape) }}">
                @error('shape') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Spray</label>
                <input type="text" name="spray" class="form-control @error('spray') is-invalid @enderror" value="{{ old('spray', $variant->spray) }}">
                @error('spray') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="product_description" class="form-control @error('product_description') is-invalid @enderror" rows="3">{{ old('product_description', $variant->product_description) }}</textarea>
                @error('product_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Color Code</label>
                <input type="text" name="product_color_code" class="form-control @error('product_color_code') is-invalid @enderror" value="{{ old('product_color_code', $variant->product_color_code) }}">
                @error('product_color_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Features</label>
                <textarea name="product_feature" class="form-control @error('product_feature') is-invalid @enderror" rows="2">{{ old('product_feature', $variant->product_feature) }}</textarea>
                @error('product_feature') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Installation / Service Parts</label>
                <textarea name="product_installation_service_parts" class="form-control @error('product_installation_service_parts') is-invalid @enderror" rows="2">{{ old('product_installation_service_parts', $variant->product_installation_service_parts) }}</textarea>
                @error('product_installation_service_parts') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Design File</label><br>
                @if($variant->design_files)
                    <a href="{{ asset('storage/' . $variant->design_files) }}" target="_blank">Download current file</a><br>
                @endif
                <input type="file" name="design_files" class="form-control-file @error('design_files') is-invalid @enderror">
                @error('design_files') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label>Additional Information</label>
                <textarea name="additional_information" class="form-control @error('additional_information') is-invalid @enderror" rows="2">{{ old('additional_information', $variant->additional_information) }}</textarea>
                @error('additional_information') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-success">Update Variant</button>
            <a href="{{ route('products.variants.index', $product->id) }}" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</form>
@stop
