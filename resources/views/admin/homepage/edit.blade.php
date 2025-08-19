@extends('adminlte::page')

@section('title', 'Home Page CMS')

@section('content_header')
    <h1 class="text-primary">Home Page CMS</h1>
@stop

<style>
    .cke_notifications_area {
        display: none;
    }
    .img-thumbnail {
        height: revert-layer !important;
    }
</style>

@section('content')
<div class="container-fluid">

    {{-- Success Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ✅ {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>There were some errors with your submission:</strong>
            <ul class="mt-2 mb-0">
                @foreach ($errors->all() as $error)
                    <li>❌ {{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <form action="{{ route('homepage.update') }}" method="POST" enctype="multipart/form-data" id="cmsForm">
        @csrf

        {{-- SECTION 1: Banner Videos --}}
        <div class="card card-outline card-primary mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>1. Banner Section</strong>
                <button type="button" id="addBannerVideo" class="btn btn-sm btn-success">
                    ➕ Add Video/Image
                </button>
            </div>
            <div class="card-body">
                <label class="form-label">Banner Videos/Image <span class="text-danger">*</span></label>

                <div id="bannerVideoInputs">
                    <div class="input-group mb-3">
                        <input type="file" name="banner_videos[]" class="form-control">
                    </div>
                </div>

                {{-- Existing videos --}}
                @if($section->banner_videos)
                    <div class="d-flex flex-wrap gap-3 mt-3">
                        @foreach($section->banner_videos as $video)
                            <video width="200" controls class="me-2 mt-2">
                                <source src="{{ asset('storage/' . $video) }}" type="video/mp4">
                            </video>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        
        
                        {{-- SECTION 1.2: Banner Videos --}}
        <div class="card card-outline card-primary mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Meta Tags: </strong>
          
            </div>
            <div class="card-body">
                <label class="form-label">Meta title: <span class="text-danger">*</span></label>

                <div id="">
                    <div class="input-group mb-3">
                        <input type="text" name="" class="form-control">
                    </div>
                </div>
                
                     <label class="form-label">Meta description: <span class="text-danger">*</span></label>

                <div id="">
                    <div class="input-group mb-3">
                        <input type="text" name="" class="form-control">
                    </div>
                </div>

            </div>
        </div>


        {{-- SECTION 2: Categories --}}
        <div class="card card-outline card-success mb-4">
            <div class="card-header"><strong>2. Categories Section</strong></div>
            <div class="card-body">
                <label class="form-label">Main Description <span class="text-danger">*</span></label>
                <textarea name="categories_description" class="form-control mb-3">{{ old('categories_description', $section->categories_description) }}</textarea>

                @php
                    $categories = ['faucet', 'showers', 'basin', 'toilet', 'furniture', 'accessories'];
                @endphp

                <div class="row">
                    @foreach ($categories as $cat)
                        <div class="col-md-4 mb-3">
                            <label>{{ ucfirst($cat) }} Image <span class="text-danger">*</span></label>
                            <input type="file" name="category_{{ $cat }}_image" class="form-control">
                            @if($section["category_{$cat}_image"])
                                <img src="{{ asset('storage/' . $section["category_{$cat}_image"]) }}" alt="{{ $cat }}" class="img-thumbnail mt-2" height="80">
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- SECTION 3: Collections --}}
        <div class="card card-outline card-warning mb-4">
            <div class="card-header"><strong>3. Collections Section</strong></div>
            <div class="card-body">
                <label>Main Description <span class="text-danger">*</span></label>
                <textarea name="collections_description" class="form-control mb-3">{{ old('collections_description', $section->collections_description) }}</textarea>

                <div class="row">
                    <div class="col-md-6">
                        <h6>Aurum</h6>
                        <label>Description <span class="text-danger">*</span></label>
                        <textarea name="aurum_description" class="form-control mb-2">{{ old('aurum_description', $section->aurum_description) }}</textarea>
                        <label>Image <span class="text-danger">*</span></label>
                        <input type="file" name="aurum_image" class="form-control mb-2">
                        @if($section->aurum_image)
                            <img src="{{ asset('storage/' . $section->aurum_image) }}" class="img-thumbnail mt-2" height="80">
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6>Klassic</h6>
                        <label>Description <span class="text-danger">*</span></label>
                        <textarea name="klassic_description" class="form-control mb-2">{{ old('klassic_description', $section->klassic_description) }}</textarea>
                        <label>Image <span class="text-danger">*</span></label>
                        <input type="file" name="klassic_image" class="form-control mb-2">
                        @if($section->klassic_image)
                            <img src="{{ asset('storage/' . $section->klassic_image) }}" class="img-thumbnail mt-2" height="80">
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 4: Locate Our Store --}}
        <div class="card card-outline card-info mb-4">
            <div class="card-header"><strong>4. World of Kerovit</strong></div>
            <div class="card-body">
                <label>Banner Image <span class="text-danger">*</span></label>
                <input type="file" name="store_banner_image" class="form-control mb-2">
                @if($section->store_banner_image)
                    <img src="{{ asset('storage/' . $section->store_banner_image) }}" class="img-thumbnail mb-3" height="80">
                @endif
                <br/>
                <label>Header <span class="text-danger">*</span></label>
                <input type="text" name="store_header" class="form-control mb-2" value="{{ old('store_header', $section->store_header) }}">

                <label>Description <span class="text-danger">*</span></label>
                <textarea name="store_description" class="form-control">{{ old('store_description', $section->store_description) }}</textarea>
            </div>
        </div>

        {{-- SECTION 5: About Us --}}
        <div class="card card-outline card-dark mb-4">
            <div class="card-header"><strong>5. Homepage About Us Section</strong></div>
            <div class="card-body">
                <label>Banner Video <span class="text-danger">*</span></label>
                <input type="file" name="about_banner_video" class="form-control mb-2">
                @if($section->about_banner_video)
                    <video width="220" controls class="mb-3">
                        <source src="{{ asset('storage/' . $section->about_banner_video) }}" type="video/mp4">
                    </video>
                @endif
            <br/>
                <label>Description <span class="text-danger">*</span></label>
                <textarea name="about_description" class="form-control">{{ old('about_description', $section->about_description) }}</textarea>
            </div>
        </div>

        {{-- Submit --}}
        <div class="text-end position-relative">
            <button id="submitBtn" class="btn btn-primary px-4 py-2">
                <span id="btnText">💾 Save Changes</span>
                <span id="btnLoader" class="spinner-border spinner-border-sm d-none ms-2"></span>
            </button>
        </div>
    </form>
</div>
@endsection

@push('js')
{{-- CKEditor --}}
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    document.querySelectorAll('textarea').forEach(el => CKEDITOR.replace(el));

    const form = document.getElementById('cmsForm');
    const submitBtn = document.getElementById('submitBtn');
    const loader = document.getElementById('btnLoader');
    const btnText = document.getElementById('btnText');

    form.addEventListener('submit', function () {
        submitBtn.disabled = true;
        loader.classList.remove('d-none');
        btnText.textContent = 'Saving...';
    });

    document.getElementById('addBannerVideo').addEventListener('click', function () {
        const container = document.getElementById('bannerVideoInputs');

        const inputGroup = document.createElement('div');
        inputGroup.classList.add('input-group', 'mb-3');

        inputGroup.innerHTML = `
            <input type="file" name="banner_videos[]" class="form-control" />
            <button type="button" class="btn btn-danger btn-sm removeBannerVideo">🗑</button>
        `;

        container.appendChild(inputGroup);

        inputGroup.querySelector('.removeBannerVideo').addEventListener('click', function () {
            inputGroup.remove();
        });
    });
</script>

@endpush
