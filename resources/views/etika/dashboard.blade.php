@extends('layouts.mantis')
@section('header-title')
    Pelaporan Dugaan Pelanggaran Etik
@endsection
@section('sidebar')
    @include('layouts.sidebar_etik')
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('etika.main') }}">Etika</a></li>
        <li class="breadcrumb-item" aria-current="page">Dashboard</li>
    </ul>
@endsection
@section('content')
    <div class="col-sm-12">
        {{-- @livewire('agenda.daftar') --}}
        <div class="card">
            <div class="card-body">
                Halo {{ Auth::user()->name }}, kamu sedang mengakses modul Etika.
            </div>
        </div>
    </div>
@endsection
