@extends('layouts.mantis')
@section('header-title')
    Akses
@endsection
@section('sidebar')
    @include('layouts.sidebar_tool')
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('akses.index') }}">Home</a></li>
        {{-- <li class="breadcrumb-item" aria-current="page">List</li> --}}
    </ul>
@endsection
@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                Halo {{ Auth::user()->name }}, kamu sedang mengakses menu Roles dan Permission menggunakan Spatie
                Permission.
            </div>
        </div>
    </div>
@endsection
