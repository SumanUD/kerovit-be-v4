@extends('adminlte::page')

@section('title', 'Create Range')

@section('content_header')
    <h1>Create New Range under Category: {{ $category->name }}</h1>
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

    <form action="{{ route('categories.ranges.store', $category->id) }}" method="POST">
        @csrf

        <div class="card">
            <div class="card-body">

                <div class="form-group">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}">
                    @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="collection_id">Collection <span class="text-danger">*</span></label>
                    
                    <input type="hidden" name="collection_id" value="{{ $collection->id }}">

                    <input type="text" class="form-control" value="{{ $collection->name }}" disabled>
                </div>


                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn btn-success">Create Range</button>
                <a href="{{ route('categories.ranges.index', $category->id) }}" class="btn btn-secondary">Cancel</a>

            </div>
        </div>
    </form>
@stop
