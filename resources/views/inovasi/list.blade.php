@extends('layouts.mantis')
@section('header-title')
    Daftar Inovasi
@endsection
@section('sidebar')
    @include('layouts.sidebar_inovasi')
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="#">Daftar Inovasi</a></li>
        {{-- <li class="breadcrumb-item" aria-current="page"><a href="{{ route('master.pegawai') }}">Pegawai</a></li> --}}
    </ul>
@endsection
@section('content')
    <div class="col-sm-12">
        @livewire('inovasi.list-inovasi')
    </div>
@endsection
