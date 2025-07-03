@extends('adminlte::page')

@section('title', 'Add Product')

@section('content_header')
    <h1>Add Product to Range: {{ $range->name }}</h1>
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

<form action="{{ route('ranges.products.store', $range->id) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card">
        <div class="card-body">

            <div class="form-group">
                <label for="product_code">Product Code <span class="text-danger">*</span></label>
                <input type="text" name="product_code" class="form-control @error('product_code') is-invalid @enderror" value="{{ old('product_code') }}" required>
                @error('product_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="product_title">Product Title <span class="text-danger">*</span></label>
                <input type="text" name="product_title" class="form-control @error('product_title') is-invalid @enderror" value="{{ old('product_title') }}" required>
                @error('product_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="product_picture">Product Picture</label>
                <input type="file" name="product_picture" class="form-control-file @error('product_picture') is-invalid @enderror">
                @error('product_picture')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="series">Series</label>
                <input type="text" name="series" class="form-control @error('series') is-invalid @enderror" value="{{ old('series') }}">
                @error('series')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="shape">Shape</label>
                <input type="text" name="shape" class="form-control @error('shape') is-invalid @enderror" value="{{ old('shape') }}">
                @error('shape')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="spray">Spray</label>
                <input type="text" name="spray" class="form-control @error('spray') is-invalid @enderror" value="{{ old('spray') }}">
                @error('spray')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="product_description">Description</label>
                <textarea name="product_description" class="form-control @error('product_description') is-invalid @enderror" rows="3">{{ old('product_description') }}</textarea>
                @error('product_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="product_color_code">Color Code</label>
                <input type="text" name="product_color_code" class="form-control @error('product_color_code') is-invalid @enderror" value="{{ old('product_color_code') }}">
                @error('product_color_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="product_feature">Features</label>
                <textarea name="product_feature" class="form-control @error('product_feature') is-invalid @enderror" rows="2">{{ old('product_feature') }}</textarea>
                @error('product_feature')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="product_installation_service_parts">Installation/Service Parts</label>
                <textarea name="product_installation_service_parts" class="form-control @error('product_installation_service_parts') is-invalid @enderror" rows="2">{{ old('product_installation_service_parts') }}</textarea>
                @error('product_installation_service_parts')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="design_files">Design File</label>
                <input type="file" name="design_files" class="form-control-file @error('design_files') is-invalid @enderror">
                @error('design_files')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="additional_information">Additional Information</label>
                <textarea name="additional_information" class="form-control @error('additional_information') is-invalid @enderror" rows="2">{{ old('additional_information') }}</textarea>
                @error('additional_information')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn btn-success">Create Product</button>
            <a href="{{ route('ranges.products.index', $range->id) }}" class="btn btn-secondary">Cancel</a>

        </div>
    </div>
</form>

@stop
