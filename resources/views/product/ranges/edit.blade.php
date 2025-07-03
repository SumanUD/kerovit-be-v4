@extends('adminlte::page')

@section('title', 'Edit Range')

@section('content_header')
    <h1>Edit Range under Category: {{ $category->name }}</h1>
@stop

@section('content')
    <form action="{{ route('categories.ranges.update', [$category->id, $range->id]) }}" method="POST">
        @csrf
        @method('PUT')

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
            <input type="hidden" name="collection_id" value="{{ $range->collection_id }}">
            <input type="text" class="form-control" value="{{ $range->collection->name }}" disabled>
        </div>

        <div class="mb-3">
            <label>Category <span class="text-danger">*</span></label>
            <input type="hidden" name="category_id" value="{{ $category->id }}">
            <input type="text" class="form-control" value="{{ $category->name }}" disabled>
        </div>

        <div class="mb-3">
            <label>Name <span class="text-danger">*</span></label>
            <input name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $range->name) }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Slug</label>
            <input name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $range->slug) }}">
            @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $range->description) }}</textarea>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-success">Update</button>
        <a href="{{ route('categories.ranges.index', $category->id) }}" class="btn btn-secondary">Cancel</a>
    </form>
@stop
