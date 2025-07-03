@extends('adminlte::page')

@section('title', 'Edit Category')

@section('content_header')
    <h1>Edit Category</h1>
@stop

@section('content')
    <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data">
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
            <label>Collection <span class="text-danger">*</span></label>
            <select name="collection_id" class="form-control @error('collection_id') is-invalid @enderror" required>
                @foreach($collections as $collection)
                    <option value="{{ $collection->id }}" {{ old('collection_id', $category->collection_id) == $collection->id ? 'selected' : '' }}>
                        {{ $collection->name }}
                    </option>
                @endforeach
            </select>
            @error('collection_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Name <span class="text-danger">*</span></label>
            <input name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Slug</label>
            <input name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $category->slug) }}">
            @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $category->description) }}</textarea>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Current Thumbnail</label><br>
            @if($category->thumbnail_image)
                <img src="{{ asset('storage/' . $category->thumbnail_image) }}" width="100">
            @else
                <span class="text-muted">No image uploaded</span>
            @endif
        </div>

        <div class="mb-3">
            <label>Change Thumbnail</label>
            <input type="file" name="thumbnail_image" class="form-control @error('thumbnail_image') is-invalid @enderror">
            @error('thumbnail_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-success">Update</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@stop
