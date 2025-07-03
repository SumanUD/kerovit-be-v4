@extends('adminlte::page')

@section('title', 'Add New Collection')

@section('content_header')
    <h1>Add New Collection</h1>
@stop

@section('content')
    <form action="{{ route('collections.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-3">
            <label>Name <span class="text-danger">*</span></label>
            <input name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Slug</label>
            <input name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}">
            @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Thumbnail Image</label>
            <input type="file" name="thumbnail_image" class="form-control @error('thumbnail_image') is-invalid @enderror">
            @error('thumbnail_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-primary">Create</button>
        <a href="{{ route('collections.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@stop
