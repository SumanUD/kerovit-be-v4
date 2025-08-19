@extends('adminlte::page')

@section('title', 'Edit Dealer')

@section('content_header')
    <h1 class="text-primary">Edit Dealer</h1>
@stop

@section('content')
<div class="container">
    <form action="{{ route('dealers.update', $dealer->id) }}" method="POST">
        @csrf
        @method('PUT')

        @include('admin.dealers.form', ['dealer' => $dealer])


    </form>
</div>
@endsection
