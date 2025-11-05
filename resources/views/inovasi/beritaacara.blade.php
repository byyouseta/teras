@extends('layouts.mantis')
@section('header-title')
    Berita Acara
@endsection
@section('sidebar')
    @include('layouts.sidebar_inovasi')
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="#">Berita Acara</a></li>
        {{-- <li class="breadcrumb-item" aria-current="page"><a href="{{ route('master.pegawai') }}">Pegawai</a></li> --}}
    </ul>
@endsection
@section('content')
    <div class="col-sm-12">
        @livewire('inovasi.berita-acara')
    </div>
@endsection
