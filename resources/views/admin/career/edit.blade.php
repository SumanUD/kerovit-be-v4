@extends('adminlte::page')

@section('title', 'Career Page CMS')

@section('content_header')
    <h1>Career Page CMS</h1>
@stop

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
    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Validation errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('career.update') }}" method="POST" enctype="multipart/form-data" id="careerForm">
        @csrf

        {{-- 1. Banner Image + Description --}}
        <div class="card card-outline card-primary mb-4">
            <div class="card-header"><strong>1. Banner Image & Description</strong></div>
            <div class="card-body">
                <label class="form-label">Banner Image <span class="text-danger">*</span></label>
                <input type="file" name="banner_image" class="form-control mb-2">
                @if($career->banner_image)
                    <img src="{{ asset('storage/' . $career->banner_image) }}" height="100" class="mt-2">
                @endif
<br/>
                <label class="form-label mt-3">Banner Description <span class="text-danger">*</span></label>
                <textarea name="banner_description" class="form-control" required>{{ old('banner_description', $career->banner_description) }}</textarea>
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

        {{-- 2. Below Banner Description --}}
        <div class="card card-outline card-info mb-4">
            <div class="card-header"><strong>2. Below Banner Description</strong></div>
            <div class="card-body">
                <textarea name="below_banner_description" class="form-control" required>{{ old('below_banner_description', $career->below_banner_description) }}</textarea>
            </div>
        </div>

        {{-- 3. Below Description Image + Apply Link --}}
        <div class="card card-outline card-success mb-4">
            <div class="card-header"><strong>3. Image + Apply Link</strong></div>
            <div class="card-body">
                <label class="form-label">Below Description Image <span class="text-danger">*</span></label>
                <input type="file" name="below_description_image" class="form-control mb-2">
                @if($career->below_description_image)
                    <img src="{{ asset('storage/' . $career->below_description_image) }}" height="100" class="mt-2">
                @endif
                <br/>
                <label class="form-label mt-3">Apply Link <span class="text-danger">*</span></label>
                <input type="url" name="apply_link" class="form-control" value="{{ old('apply_link', $career->apply_link) }}">
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary" id="submitBtn">
                <span class="spinner-border spinner-border-sm d-none" id="loader"></span>
                <span id="btnText">Save Changes</span>
            </button>
        </div>
    </form>
</div>
@endsection

@push('js')
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    document.querySelectorAll('textarea').forEach(el => CKEDITOR.replace(el));
    document.getElementById('careerForm').addEventListener('submit', function () {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        document.getElementById('loader').classList.remove('d-none');
        document.getElementById('btnText').textContent = 'Saving...';
    });
</script>
@endpush
