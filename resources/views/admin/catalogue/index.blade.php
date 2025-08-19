{{-- resources/views/admin/catalogue/index.blade.php --}}
@extends('adminlte::page')

@section('title', 'Catalogue Page CMS')


<style>
    .cke_notifications_area {
        display: none;
    }
        .main-sidebar{
        position: fixed !important;
    }
</style>

@section('content')
<div class="container">
    {{-- ✅ Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ❌ Error Messages --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="cmsForm" action="{{ route('catalogue.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Main Description Section --}}
        <div class="card card-outline card-primary mb-4">
            <div class="card-header"><strong>Main Catalogue Description <span class="text-danger">*</span></strong></div>
            <div class="card-body">
                <textarea name="description"
                          class="form-control @error('description') is-invalid @enderror"
                          rows="4"
                          required>{{ old('description', $catalogue->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Meta Section --}}
        <div class="card card-outline card-primary mb-4">
            <div class="card-header"><strong>Meta Tags</strong></div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Meta Title</label>
                    <input type="text"
                           name="meta_title"
                           value="{{ old('meta_title', $catalogue->meta_title ?? '') }}"
                           class="form-control @error('meta_title') is-invalid @enderror">
                    @error('meta_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Meta Description</label>
                    <input type="text"
                           name="meta_description"
                           value="{{ old('meta_description', $catalogue->meta_description ?? '') }}"
                           class="form-control @error('meta_description') is-invalid @enderror">
                    @error('meta_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Catalogue Categories --}}
        <div class="card card-outline card-info mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Catalogue Categories <span class="text-danger">*</span></strong>
                <button type="button" id="addCategory" class="btn btn-sm btn-success">+ Add Category</button>
            </div>

            <div class="card-body" id="categoriesWrapper">
                @foreach ($catalogue->categories as $category)
                    <div class="category-block border rounded p-3 mb-3 position-relative bg-light">
                        <input type="hidden" name="categories[{{ $loop->index }}][id]" value="{{ $category->id }}">

                        {{-- Delete existing category (no nested form; handled via JS) --}}
                        <button type="button"
                                class="btn btn-sm btn-danger position-absolute top-0 end-0 deleteCategoryBtn ml-5"
                                title="Delete category"
                                data-url="{{ route('catalogue.category.destroy', $category->id) }}">
                            &times; Delete
                        </button>

                        <div class="mb-2">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="categories[{{ $loop->index }}][title]"
                                   class="form-control @error('categories.' . $loop->index . '.title') is-invalid @enderror"
                                   value="{{ old('categories.' . $loop->index . '.title', $category->title) }}"
                                   required>
                            @error('categories.' . $loop->index . '.title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Thumbnail Image</label>
                            <input type="file"
                                   name="categories[{{ $loop->index }}][thumbnail_image]"
                                   class="form-control @error('categories.' . $loop->index . '.thumbnail_image') is-invalid @enderror">
                            @error('categories.' . $loop->index . '.thumbnail_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if($category->thumbnail_image)
                                <img src="{{ asset('storage/' . $category->thumbnail_image) }}"
                                     alt="thumb"
                                     class="mt-2 border rounded"
                                     height="60">
                            @endif
                        </div>

                        <div>
                            <label class="form-label">PDF Link</label>
                            <input type="file"
                                   name="categories[{{ $loop->index }}][pdf_link]"
                                   class="form-control @error('categories.' . $loop->index . '.pdf_link') is-invalid @enderror">
                            @error('categories.' . $loop->index . '.pdf_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if($category->pdf_link)
                                <a href="{{ asset('storage/' . $category->pdf_link) }}"
                                   target="_blank"
                                   class="d-block mt-2">View PDF</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="text-end">
            <button type="submit" id="submitBtn" class="btn btn-primary">
                <span id="btnLoader" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                <span id="btnText">Save Changes</span>
            </button>
        </div>
    </form>
</div>

{{-- 🔥 Fullscreen Loader Overlay --}}
<div id="overlayLoader"
     class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-none"
     style="z-index: 1050; display:flex; align-items:center; justify-content:center;">
    <div class="spinner-border text-light" role="status" style="width:3rem;height:3rem;"></div>
</div>
@endsection

@push('js')

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    document.querySelectorAll('textarea').forEach(el => CKEDITOR.replace(el));
    // --- Config ---
    const csrfToken = '{{ csrf_token() }}';
    let categoryIndex = {{ $catalogue->categories->count() }};

    // --- Helpers ---
    function showSavingState() {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        document.getElementById('btnLoader').classList.remove('d-none');
        document.getElementById('btnText').textContent = 'Saving...';
        document.getElementById('overlayLoader').classList.remove('d-none');
    }

    function postDelete(url) {
        if (!confirm('Are you sure you want to delete this? This action cannot be undone.')) return;

        // Create and submit a standalone form for DELETE
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = url;

        const token = document.createElement('input');
        token.type = 'hidden';
        token.name = '_token';
        token.value = csrfToken;
        form.appendChild(token);

        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';
        form.appendChild(method);

        document.body.appendChild(form);
        showSavingState();
        form.submit();
    }

    // --- Add new category block dynamically ---
    document.getElementById('addCategory').addEventListener('click', function () {
        const wrapper = document.getElementById('categoriesWrapper');
        const idx = categoryIndex;

        const html = `
            <div class="category-block border rounded p-3 mb-3 position-relative bg-light ml-5">
                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 removeCategory" title="Remove unsaved category">× Delete</button>

                <div class="mb-2">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="categories[${idx}][title]" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label class="form-label">Thumbnail Image</label>
                    <input type="file" name="categories[${idx}][thumbnail_image]" class="form-control">
                </div>

                <div>
                    <label class="form-label">PDF Link</label>
                    <input type="file" name="categories[${idx}][pdf_link]" class="form-control">
                </div>
            </div>
        `;

        wrapper.insertAdjacentHTML('beforeend', html);
        categoryIndex++;
    });

    // --- Remove unsaved category (frontend only) & delete existing category (via JS form) ---
    document.addEventListener('click', function (e) {
        // Remove unsaved
        if (e.target.classList.contains('removeCategory')) {
            e.target.closest('.category-block').remove();
        }

        // Delete existing (server-side)
        if (e.target.classList.contains('deleteCategoryBtn')) {
            const url = e.target.getAttribute('data-url');
            postDelete(url);
        }
    });

    // --- Loader on form submit ---
    document.getElementById('cmsForm').addEventListener('submit', function () {
        showSavingState();
    });

    // --- Remove current catalogue (server-side) ---
    document.getElementById('removeCatalogueBtn').addEventListener('click', function () {
        const url = this.getAttribute('data-url');
        postDelete(url);
    });
</script>
@endpush
