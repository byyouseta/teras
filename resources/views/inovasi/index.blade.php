@extends('layouts.mantis')
@section('header-title')
    Inovasi
@endsection
@section('sidebar')
    @include('layouts.sidebar_inovasi')
@endsection

@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('inovasi.index') }}">Dashboard</a></li>
        {{-- <li class="breadcrumb-item" aria-current="page">List</li> --}}
    </ul>
@endsection
@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                Halo {{ Auth::user()->name }}, kamu sedang mengakses modul Inovasi.
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2 f-w-400 text-muted">Total Inovasi yang diajukan periode ini</h6>
                <h4 class="mb-3">{{ number_format($inovasiTahunIni->count(), 0, ',', '.') }}
                    <span class="badge bg-light-primary border border-primary"><i class="ti ti-trending-up"></i>
                        {{ number_format($persentaseTotal, 2, ',', '.') }}
                    </span>
                </h4>
                <p class="mb-0 text-muted text-sm">Perbandingan dengan tahun lalu <span
                        class="text-primary">{{ $inovasiTahunLalu->count() }}</span>
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2 f-w-400 text-muted">Inovasi yang disetujui</h6>
                <h4 class="mb-3">{{ $inovasiTahunIni->where('status', 'diterima')->count() }} <span
                        class="badge bg-light-success border border-success"><i class="ti ti-checks"></i>
                        {{ number_format($persentaseDiterima, 2, ',', '.') }}</span>
                </h4>
                <p class="mb-0 text-muted text-sm">Perbandingan dengan tahun lalu <span
                        class="text-success">{{ $inovasiTahunLalu->where('status', 'diterima')->count() }}</span></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2 f-w-400 text-muted">Inovasi yang diajukan</h6>
                <h4 class="mb-3">{{ $inovasiTahunIni->where('status', 'diajukan')->count() }} <span
                        class="badge bg-light-warning border border-warning"><i class="ti ti-send"></i>
                        {{ number_format($persentaseDiajukan, 2, ',', '.') }}</span></h4>
                <p class="mb-0 text-muted text-sm">Perbandingan dengan tahun lalu <span
                        class="text-warning">{{ $inovasiTahunLalu->where('status', 'diajukan')->count() }}</span>
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2 f-w-400 text-muted">Inovasi yang ditolak</h6>
                <h4 class="mb-3">{{ $inovasiTahunIni->where('status', 'ditolak')->count() }} <span
                        class="badge bg-light-danger border border-danger"><i class="ti ti-circle-x"></i>
                        {{ number_format($persentaseDitolak, 2, ',', '.') }}</span>
                </h4>
                <p class="mb-0 text-muted text-sm">Perbandingan dengan tahun lalu <span
                        class="text-danger">{{ $inovasiTahunLalu->where('status', 'ditolak')->count() }}</span>
                </p>
            </div>
        </div>
    </div>
@endsection
