@extends('adminlte::page')

@section('title', isset($blog) ? 'Edit Blog' : 'Add Blog')

@section('content_header')
<h1>{{ isset($blog) ? 'Edit Blog' : 'Add New Blog' }}</h1>
@stop

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>There were some problems with your input:</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<form action="{{ isset($blog) ? route('blogs.update', $blog->id) : route('blogs.store') }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @if(isset($blog))
        @method('PUT')
    @endif

    <div class="form-group">
        <label>Title <span class="text-danger">*</span></label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $blog->title ?? '') }}" required>
    </div>

    <div class="form-group">
        <label>Banner Image <span class="text-danger">*</span></label>
        @if(isset($blog) && $blog->banner_image)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $blog->banner_image) }}" width="100" class="rounded border">
            </div>
        @endif
        <input type="file" name="banner_image" class="form-control" {{ isset($blog) ? '' : 'required' }}>
    </div>

    <div class="form-group">
        <label>Published Date <span class="text-danger">*</span></label>
        <input type="date" name="published_date" class="form-control"
            value="{{ old('published_date', isset($blog) ? $blog->published_date->format('Y-m-d') : now()->format('Y-m-d')) }}"
            required>
    </div>

    <div class="form-group form-check">
        <input type="checkbox" name="is_popular" class="form-check-input" id="is_popular" {{ old('is_popular', $blog->is_popular ?? false) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_popular">Mark as Popular</label>
    </div>


    <div class="form-group">
        <label>Description <span class="text-danger">*</span></label>
        <textarea name="description" id="description" class="form-control" rows="8"
            required>{{ old('description', $blog->description ?? '') }}</textarea>
    </div>

    <div class="form-group">
        <label>Meta Title</label>
        <input type="text" name="meta_title" class="form-control"
            value="{{ old('meta_title', $blog->meta_title ?? '') }}">
    </div>

    <div class="form-group">
        <label>Meta Description</label>
        <textarea name="meta_description" class="form-control"
            rows="3">{{ old('meta_description', $blog->meta_description ?? '') }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">
        {{ isset($blog) ? 'Update Blog' : 'Create Blog' }}
    </button>
    <a href="{{ route('blogs.index') }}" class="btn btn-secondary">Back to List</a>
</form>
@stop

@push('js')
    <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('description');
    </script>
@endpush