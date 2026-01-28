@extends('layouts.mantis_front')
@section('header-title')
    Pelaporan Dugaan Pelanggaran Etik
@endsection
@section('content')
    <div class="col-sm-12">
        @livewire('etika.pelaporan-etika')
    </div>
@endsection
