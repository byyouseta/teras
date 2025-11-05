@extends('layouts.mantis')
@section('header-title')
    Daftar Agenda
@endsection
@section('sidebar')
    @include('layouts.sidebar_patrik')
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="#">Agenda</a></li>
        <li class="breadcrumb-item" aria-current="page">List</li>
    </ul>
@endsection
@section('content')
    <div class="col-sm-12">
        @livewire('agenda.daftar')
    </div>
@endsection
