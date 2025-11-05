@extends('layouts.mantis')
@section('header-title')
    Detail Agenda
@endsection
@section('sidebar')
    @include('layouts.sidebar_patrik')
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="#">Agenda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('agenda.list') }}">List</a></li>
        <li class="breadcrumb-item" aria-current="page">Detail</li>
    </ul>
@endsection
@section('content')
    <div class="col-sm-12">
        @livewire('agenda.detail')
    </div>
@endsection
