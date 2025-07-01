@extends('adminlte::page')

@section('title', 'About Us Page CMS')

@section('content_header')
    <h1>About Us Page CMS</h1>
@stop

@section('content')
<div class="container">

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Error Messages --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems with your input:</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('about.update') }}" method="POST" enctype="multipart/form-data" id="aboutForm">
        @csrf

        {{-- 1. Banner Video --}}
        <div class="card card-outline card-primary mb-4">
            <div class="card-header"><strong>1. Banner Video <span class="text-danger">*</span></strong></div>
            <div class="card-body">
                <input type="file" name="banner_video" class="form-control">
                @error('banner_video') <small class="text-danger">{{ $message }}</small> @enderror

                @if($about->banner_video)
                    <video width="300" controls class="mt-2">
                        <source src="{{ asset('storage/' . $about->banner_video) }}" type="video/mp4">
                    </video>
                @endif
            </div>
        </div>

        {{-- 2. Below Banner Description --}}
        <div class="card card-outline card-info mb-4">
            <div class="card-header"><strong>2. Below Banner Description <span class="text-danger">*</span></strong></div>
            <div class="card-body">
                <textarea name="below_banner_description" class="form-control" required>{{ old('below_banner_description', $about->below_banner_description) }}</textarea>
                @error('below_banner_description') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        {{-- 3. Director Image --}}
        <div class="card card-outline card-primary mb-4">
            <div class="card-header"><strong>3. Director Image <span class="text-danger">*</span></strong></div>
            <div class="card-body">
                <input type="file" name="director_image" class="form-control">
                @error('director_image') <small class="text-danger">{{ $message }}</small> @enderror

                @if($about->director_image)
                    <img src="{{ asset('storage/' . $about->director_image) }}" height="100" class="mt-2">
                @endif
            </div>
        </div>

        {{-- 4. Director Description --}}
        <div class="card card-outline card-info mb-4">
            <div class="card-header"><strong>4. Director Description <span class="text-danger">*</span></strong></div>
            <div class="card-body">
                <textarea name="director_description" class="form-control" required>{{ old('director_description', $about->director_description) }}</textarea>
                @error('director_description') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        {{-- 5. Manufacturing Plants --}}
        <div class="card card-outline card-warning mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>5. Manufacturing Plants <span class="text-danger">*</span></strong>
                <button type="button" class="btn btn-sm btn-success" id="addPlant">+ Add Plant</button>
            </div>
            <div class="card-body" id="plantWrapper">
                @foreach($about->plants as $index => $plant)
                    <div class="plant-block border p-3 mb-3 position-relative rounded">
                        <input type="hidden" name="plants[{{ $index }}][id]" value="{{ $plant->id }}">
                        <button type="button" class="btn-close position-absolute top-0 end-0 removePlant"></button>

                        <label>Plant Title <span class="text-danger">*</span></label>
                        <input type="text" name="plants[{{ $index }}][plant_title]" class="form-control mb-2" value="{{ $plant->plant_title }}" required>
                        @error("plants.$index.plant_title") <small class="text-danger">{{ $message }}</small> @enderror

                        <label>Plant Image</label>
                        <input type="file" name="plants[{{ $index }}][plant_image]" class="form-control mb-2">
                        @if($plant->plant_image)
                            <img src="{{ asset('storage/' . $plant->plant_image) }}" height="80">
                        @endif
                        @error("plants.$index.plant_image") <small class="text-danger">{{ $message }}</small> @enderror

                        <label>Plant Description <span class="text-danger">*</span></label>
                        <textarea name="plants[{{ $index }}][plant_description]" class="form-control" required>{{ $plant->plant_description }}</textarea>
                        @error("plants.$index.plant_description") <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                @endforeach
            </div>
        </div>

        {{-- 6. Certification Images --}}
        <div class="card card-outline card-primary mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>6. Certification Images <span class="text-danger">*</span></strong>
                <button type="button" class="btn btn-sm btn-success" id="addCertImage">+ Add Image</button>
            </div>
            <div class="card-body" id="certImageWrapper">
                <div class="cert-upload mb-3">
                    <input type="file" name="certification_images[]" class="form-control">
                </div>
                @error('certification_images.*') <small class="text-danger">{{ $message }}</small> @enderror

                @if(is_array($about->certification_images))
                    <div class="d-flex flex-wrap gap-2 mt-3">
                        @foreach($about->certification_images as $img)
                            <img src="{{ asset('storage/' . $img) }}" height="80" class="border rounded">
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="text-end">
            <button class="btn btn-primary" id="submitBtn">
                <span class="spinner-border spinner-border-sm d-none" id="loader"></span>
                <span id="btnText">Save Changes</span>
            </button>
        </div>
    </form>
</div>
@endsection

@push('js')
<script>
    let plantIndex = {{ $about->plants->count() }};

    document.getElementById('addPlant').addEventListener('click', function () {
        const wrapper = document.getElementById('plantWrapper');

        const html = `
            <div class="plant-block border p-3 mb-3 position-relative rounded">
                <button type="button" class="btn-close position-absolute top-0 end-0 removePlant"></button>

                <label>Plant Title <span class="text-danger">*</span></label>
                <input type="text" name="plants[${plantIndex}][plant_title]" class="form-control mb-2" required>

                <label>Plant Image</label>
                <input type="file" name="plants[${plantIndex}][plant_image]" class="form-control mb-2">

                <label>Plant Description <span class="text-danger">*</span></label>
                <textarea name="plants[${plantIndex}][plant_description]" class="form-control" required></textarea>
            </div>
        `;

        wrapper.insertAdjacentHTML('beforeend', html);
        plantIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('removePlant')) {
            e.target.closest('.plant-block').remove();
        }
    });

    document.getElementById('addCertImage').addEventListener('click', function () {
        const container = document.createElement('div');
        container.className = 'cert-upload mb-3';

        const input = document.createElement('input');
        input.type = 'file';
        input.name = 'certification_images[]';
        input.className = 'form-control';

        container.appendChild(input);
        document.getElementById('certImageWrapper').appendChild(container);
    });

    document.getElementById('aboutForm').addEventListener('submit', function () {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        document.getElementById('loader').classList.remove('d-none');
        document.getElementById('btnText').textContent = 'Saving...';
    });
</script>
@endpush
