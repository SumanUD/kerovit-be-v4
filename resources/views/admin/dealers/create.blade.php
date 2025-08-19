@extends('adminlte::page')

@section('title', 'Add Dealer')

@section('content_header')
    <h1 class="text-primary">Add Dealer</h1>
@stop

@section('content')
<div class="container">
    <form action="{{ route('dealers.store') }}" method="POST">
        @csrf

        @include('admin.dealers.form')


    </form>
</div>
@endsection
