@extends('layouts.mantis')
@section('header-title')
    Permission
@endsection
@section('sidebar')
    @include('layouts.sidebar_tool')
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('akses.permission') }}">Permission</a></li>
        <li class="breadcrumb-item" aria-current="page">List</li>
    </ul>
@endsection
@section('content')
    <div class="col-sm-12">
        @livewire('akses.permission')
    </div>
@endsection
