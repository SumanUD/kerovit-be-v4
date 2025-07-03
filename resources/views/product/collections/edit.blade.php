@extends('adminlte::page')

@section('title', 'Edit Collection')

@section('content_header')
    <h1>Edit Collection</h1>
@stop

@section('content')
    <form action="{{ route('collections.update', $collection) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

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
            <input name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $collection->name) }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Slug</label>
            <input name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $collection->slug) }}">
            @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $collection->description) }}</textarea>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Current Thumbnail</label><br>
            @if($collection->thumbnail_image)
                <img src="{{ asset('storage/' . $collection->thumbnail_image) }}" width="100" class="mb-2">
            @else
                <span class="text-muted">No Image</span>
            @endif
        </div>

        <div class="mb-3">
            <label>New Thumbnail</label>
            <input type="file" name="thumbnail_image" class="form-control @error('thumbnail_image') is-invalid @enderror">
            @error('thumbnail_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-success">Update</button>
        <a href="{{ route('collections.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@stop
