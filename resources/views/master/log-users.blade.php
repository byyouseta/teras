@extends('layouts.mantis')
@section('header-title')
    Master Users
@endsection
@section('sidebar')
    @include('layouts.sidebar_tool')
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="#">Master</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('master.logusers') }}">Log Users</a></li>
    </ul>
@endsection
@section('content')
    <div class="col-sm-12">
        @livewire('master.log-users')
    </div>
@endsection
