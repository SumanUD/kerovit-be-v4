@extends('adminlte::page')

@section('title', 'Customer Care Page CMS')

@section('content_header')
    <h1>Customer Care Page CMS</h1>
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
    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('customer-care.update') }}" method="POST" enctype="multipart/form-data" id="customerCareForm">
        @csrf

        {{-- 1. Banner Image --}}
        <div class="card card-outline card-primary mb-4">
            <div class="card-header"><strong>1. Banner Image</strong></div>
            <div class="card-body">
                <label class="form-label">Banner Image <span class="text-danger">*</span></label>
                <input type="file" name="banner_image" class="form-control mb-2">
                @if($care->banner_image)
                    <img src="{{ asset('storage/' . $care->banner_image) }}" height="100" class="mt-2">
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

        {{-- 2. Below Banner Image --}}
        <div class="card card-outline card-info mb-4">
            <div class="card-header"><strong>2. Below Banner Image</strong></div>
            <div class="card-body">
                <label class="form-label">Below Banner Image <span class="text-danger">*</span></label>
                <input type="file" name="below_banner_image" class="form-control mb-2">
                @if($care->below_banner_image)
                    <img src="{{ asset('storage/' . $care->below_banner_image) }}" height="100" class="mt-2">
                @endif
            </div>
        </div>

        {{-- 3. Email Section --}}
        <div class="card card-outline card-warning mb-4">
            <div class="card-header"><strong>3. Email Section</strong></div>
            <div class="card-body">
                <label class="form-label">Service Query Email <span class="text-danger">*</span></label>
                <input type="email" name="service_query_email" class="form-control mb-3" value="{{ old('service_query_email', $care->service_query_email) }}">

                <label class="form-label">Info Email <span class="text-danger">*</span></label>
                <input type="email" name="info_email" class="form-control" value="{{ old('info_email', $care->info_email) }}">
            </div>
        </div>

        {{-- 4. Customer Care Section --}}
        <div class="card card-outline card-success mb-4">
            <div class="card-header"><strong>4. Customer Care Info</strong></div>
            <div class="card-body">
                <label class="form-label">Call Number <span class="text-danger">*</span></label>
                <input type="text" name="call_number" class="form-control mb-3" value="{{ old('call_number', $care->call_number) }}">

                <label class="form-label">Toll-Free Number <span class="text-danger">*</span></label>
                <input type="text" name="tollfree_number" class="form-control mb-3" value="{{ old('tollfree_number', $care->tollfree_number) }}">

                <label class="form-label">WhatsApp Chat Number <span class="text-danger">*</span></label>
                <input type="text" name="whatsapp_chat" class="form-control" value="{{ old('whatsapp_chat', $care->whatsapp_chat) }}">
            </div>
        </div>

        {{-- Submit --}}
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
<script>
    document.getElementById('customerCareForm').addEventListener('submit', function () {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        document.getElementById('loader').classList.remove('d-none');
        document.getElementById('btnText').textContent = 'Saving...';
    });
</script>
@endpush
