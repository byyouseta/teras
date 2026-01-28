@extends('layouts.mantis')
@section('header-title')
    PATRIK (Rapat Elektronik)
@endsection
@section('sidebar')
    @include('layouts.sidebar_patrik')
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
                Halo {{ Auth::user()->name }}, kamu sedang mengakses modul PATRIK (Rapat Elektronik).
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2 f-w-400 text-muted">Total Agenda yang diajukan bulan ini</h6>
                <h4 class="mb-3">{{ $agendaBulanIni->count() }}
                    <span class="badge bg-light-primary border border-primary"><i class="ti ti-trending-up"></i>
                        {{ number_format(($agendaBulanIni->count() / $agendaBulanLalu->count()) * 100 ?? 0, 2, ',', '.') }}%
                    </span>
                </h4>
                <p class="mb-0 text-muted text-sm">Perbandingan dengan bulan lalu <span
                        class="text-primary">{{ $agendaBulanLalu->count() }}</span>
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2 f-w-400 text-muted">Agenda yang disetujui</h6>
                <h4 class="mb-3">{{ $agendaBulanIni->where('status', '!=', 'Ditolak')->count() }}<span
                        class="badge bg-light-success border border-success"><i class="ti ti-checks"></i>
                        {{ number_format(($agendaBulanIni->where('status', '!=', 'Ditolak')->count() / $agendaBulanLalu->where('status', '!=', 'Ditolak')->count()) * 100 ?? 0, 2, ',', '.') }}</span>
                </h4>
                <p class="mb-0 text-muted text-sm">Perbandingan dengan bulan lalu <span
                        class="text-success">{{ $agendaBulanLalu->where('status', '!=', 'Ditolak')->count() }}</span></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2 f-w-400 text-muted">Agenda yang ditolak</h6>
                <h4 class="mb-3">{{ $agendaBulanIni->where('status', '=', 'Ditolak')->count() }}<span
                        class="badge bg-light-danger border border-danger"><i class="ti ti-circle-x"></i>
                        {{ number_format(($agendaBulanIni->where('status', '=', 'Ditolak')->count() / $agendaBulanLalu->where('status', '=', 'Ditolak')->count()) * 100 ?? 0, 2, ',', '.') }}</span>
                </h4>
                <p class="mb-0 text-muted text-sm">Perbandingan dengan bulan lalu <span
                        class="text-danger">{{ $agendaBulanLalu->where('status', '=', 'Ditolak')->count() }}</span>
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2 f-w-400 text-muted">Agenda yang sudah selesai</h6>
                <h4 class="mb-3">{{ $agendaBulanIni->where('status', '=', 'Selesai')->count() }}<span
                        class="badge bg-light-info border border-info"><i class="ti ti-check"></i>
                        {{ number_format(($agendaBulanIni->where('status', '=', 'Selesai')->count() / $agendaBulanLalu->where('status', '=', 'Selesai')->count()) * 100 ?? 0, 2, ',', '.') }}</span>
                </h4>
                <p class="mb-0 text-muted text-sm">Perbandingan dengan bulan lalu <span
                        class="text-info">{{ $agendaBulanLalu->where('status', '=', 'Selesai')->count() }}</span>
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xl-8">
        <h5 class="mb-3">Agenda Statistik</h5>
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2 f-w-400 text-muted">Agenda yang diajukan Tahun ini</h6>
                <h3 class="mb-0">{{ $dataAgenda->count() }}</h3>
                @livewire('agenda.stat-agenda-bulanan')
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xl-4">
        <h5 class="mb-3">Agenda Hari ini</h5>
        <div class="card">
            <div class="list-group list-group-flush">
                <a href="{{ route('agenda.list', ['view' => 'today']) }}" class="list-group-item list-group-item-action">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-s rounded-circle text-success bg-light-success">
                                <i class="ti ti-gift f-18"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Agenda hari ini</h6>
                            <p class="mb-0 text-muted">
                                {{ $dataAgenda->where('tanggal', \Carbon\Carbon::now()->format('Y-m-d'))->count() }}
                                agenda</p>
                        </div>
                        {{-- <div class="flex-shrink-0 text-end">
                            <h6 class="mb-1">+ $1,430</h6>
                            <p class="mb-0 text-muted">78%</P>
                        </div> --}}
                    </div>
                </a>
                <a href="{{ route('agenda.list', ['status' => 'Pengajuan']) }}"
                    class="list-group-item list-group-item-action">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-s rounded-circle text-primary bg-light-primary">
                                <i class="ti ti-pencil f-18"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Perlu Approval</h6>
                            <p class="mb-0 text-muted">{{ $dataAgenda->where('status', 'Pengajuan')->count() }} Agenda</p>
                        </div>
                        {{-- <div class="flex-shrink-0 text-end">
                            <h6 class="mb-1">- $302</h6>
                            <p class="mb-0 text-muted">8%</P>
                        </div> --}}
                    </div>
                </a>
                {{-- <a href="#" class="list-group-item list-group-item-action">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-s rounded-circle text-danger bg-light-danger">
                                <i class="ti ti-settings f-18"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Order #988784</h6>
                            <p class="mb-0 text-muted">7 hours ago</P>
                        </div>
                        <div class="flex-shrink-0 text-end">
                            <h6 class="mb-1">- $682</h6>
                            <p class="mb-0 text-muted">16%</P>
                        </div>
                    </div>
                </a> --}}
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('mantis/assets/js/plugins/apexcharts.min.js') }}"></script>
@endpush
