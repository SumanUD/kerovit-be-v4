@extends('adminlte::page')

@section('title', 'Catalogue Page CMS')

@section('content_header')
    <h1>Catalogue Page CMS</h1>
@stop

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form id="cmsForm" action="{{ route('catalogue.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Description Section --}}
        <div class="card card-outline card-primary mb-4">
            <div class="card-header"><strong>Main Catalogue Description <span class="text-danger">*</span></strong></div>
            <div class="card-body">
                <textarea name="description" class="form-control" required>{{ old('description', $catalogue->description) }}</textarea>
            </div>
        </div>

        {{-- Catalogue Categories Section --}}
        <div class="card card-outline card-info mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Catalogue Categories <span class="text-danger">*</span></strong>
                <button type="button" id="addCategory" class="btn btn-sm btn-success">+ Add Category</button>
            </div>
            <div class="card-body" id="categoriesWrapper">
                @foreach ($catalogue->categories as $index => $category)
                    <div class="category-block border p-3 mb-3 position-relative">
                        <input type="hidden" name="categories[{{ $index }}][id]" value="{{ $category->id }}">
                        <button type="button" class="btn-close position-absolute top-0 end-0 removeCategory" aria-label="Close"></button>
                        <div class="mb-2">
                            <label>Title <span class="text-danger">*</span></label>
                            <input type="text" name="categories[{{ $index }}][title]" class="form-control" value="{{ $category->title }}" required>
                        </div>
                        <div class="mb-2">
                            <label>Thumbnail Image</label>
                            <input type="file" name="categories[{{ $index }}][thumbnail_image]" class="form-control">
                            @if($category->thumbnail_image)
                                <img src="{{ asset('storage/' . $category->thumbnail_image) }}" alt="thumb" class="mt-2" height="60">
                            @endif
                        </div>
                        <div>
                            <label>PDF Link</label>
                            <input type="file" name="categories[{{ $index }}][pdf_link]" class="form-control">
                            @if($category->pdf_link)
                                <a href="{{ asset('storage/' . $category->pdf_link) }}" target="_blank" class="d-block mt-2">View PDF</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="text-end">
            <button type="submit" id="submitBtn" class="btn btn-primary">
                <span id="btnLoader" class="spinner-border spinner-border-sm d-none"></span>
                <span id="btnText">Save Changes</span>
            </button>
        </div>
    </form>
</div>
@endsection

@push('js')
<script>
    let categoryIndex = {{ $catalogue->categories->count() }};

    document.getElementById('addCategory').addEventListener('click', function () {
        const wrapper = document.getElementById('categoriesWrapper');

        const html = `
            <div class="category-block border p-3 mb-3 position-relative">
                <button type="button" class="btn-close position-absolute top-0 end-0 removeCategory" aria-label="Close"></button>
                <div class="mb-2">
                    <label>Title <span class="text-danger">*</span></label>
                    <input type="text" name="categories[\${categoryIndex}][title]" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Thumbnail Image</label>
                    <input type="file" name="categories[\${categoryIndex}][thumbnail_image]" class="form-control">
                </div>
                <div>
                    <label>PDF Link</label>
                    <input type="file" name="categories[\${categoryIndex}][pdf_link]" class="form-control">
                </div>
            </div>
        `;

        wrapper.insertAdjacentHTML('beforeend', html);
        categoryIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('removeCategory')) {
            e.target.closest('.category-block').remove();
        }
    });

    document.getElementById('cmsForm').addEventListener('submit', function () {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        document.getElementById('btnLoader').classList.remove('d-none');
        document.getElementById('btnText').textContent = 'Saving...';
    });
</script>
@endpush
