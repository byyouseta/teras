@extends('layouts.mantis')
@section('header-title')
    Master Unit
@endsection
@section('sidebar')
    @include('layouts.sidebar_patrik')
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="#">Master</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('master.unit') }}">Unit</a></li>
    </ul>
@endsection
@section('content')
    <div class="col-sm-12">
        @livewire('master.unit')
    </div>
@endsection
