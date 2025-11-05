@extends('layouts.mantis_nosidebar')
@section('header-title')
    Main Menus
@endsection
@section('content')
    <div class="col-sm-8">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    Main Menu
                </div>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-sm mb-3">
                        @can('Patrik-Agenda-Create')
                            <a href="{{ route('agenda.dashboard') }}" class="text-decoration-none">
                            @else
                                <a href="javascript:void(0)" class="text-decoration-none disabled"
                                    title="Anda tidak memiliki akses ke menu ini" style="cursor: not-allowed;">
                                @endcan
                                <div class="card shadow-sm h-100">
                                    <div class="card-body text-center">
                                        <img src="{{ asset('assets/images/discussion.png') }}" alt="Agenda" class="mb-3"
                                            style="max-height: 50px;">
                                        <h5 class="card-title">PATRIK</h5>
                                        <p class="card-text text-muted">Rapat Elektronik</p>
                                    </div>
                                </div>
                            </a>
                    </div>
                    <div class="col-sm mb-3">
                        <a href="#" class="text-decoration-none">
                            <div class="card shadow-sm h-100">
                                <div class="card-body text-center">
                                    <img src="{{ asset('assets/images/bonus.png') }}" alt="Gratifikasi" class="mb-3"
                                        style="max-height: 50px;">
                                    <h5 class="card-title">SIPPOL</h5>
                                    <p class="card-text text-muted">Layanan Pelaporan Gratifikasi Online</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm mb-3">
                        <a href="{{ route('inovasi.index') }}" class="text-decoration-none">
                            <div class="card shadow-sm h-100">
                                <div class="card-body text-center">
                                    <img src="{{ asset('assets/images/solution.png') }}" alt="Inovasi" class="mb-3"
                                        style="max-height: 50px;">
                                    <h5 class="card-title">SI NOVA</h5>
                                    <p class="card-text text-muted">Sistem Informasi Verifikasi Inovasi</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm mb-3">
                        <a href="#" class="text-decoration-none">
                            <div class="card shadow-sm h-100">
                                <div class="card-body text-center">
                                    <img src="{{ asset('assets/images/evaluation.png') }}" alt="Evaluasi" class="mb-3"
                                        style="max-height: 50px;">
                                    <h5 class="card-title">SI EVAIN</h5>
                                    <p class="card-text text-muted">Sistem Informasi Evaluasi Akuntabilitas Internal</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    {{-- <div class="col-sm mb-3">
                        <a href="#" class="text-decoration-none">
                            <div class="card shadow-sm h-100">
                                <div class="card-body text-center">
                                    <img src="{{ asset('assets/images/discussion.png') }}" alt="Agenda" class="mb-3"
                                        style="max-height: 50px;">
                                    <h5 class="card-title">PATRIK</h5>
                                    <p class="card-text text-muted">Rapat Elektronik</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm mb-3">
                        <a href="#" class="text-decoration-none">
                            <div class="card shadow-sm h-100">
                                <div class="card-body text-center">
                                    <img src="{{ asset('assets/images/bonus.png') }}" alt="Gratifikasi" class="mb-3"
                                        style="max-height: 50px;">
                                    <h5 class="card-title">Pelaporan Gratifikasi</h5>
                                    <p class="card-text text-muted">Layanan pelaporan gratifikasi online</p>
                                </div>
                            </div>
                        </a>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    Tools Menu
                </div>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-sm mb-3">
                        <a href="{{ route('profile.edit') }}" class="text-decoration-none">
                            <div class="card shadow-sm h-100">
                                <div class="card-body text-center">
                                    <img src="{{ asset('assets/images/user-key.png') }}" alt="Agenda" class="mb-3"
                                        style="max-height: 50px;">
                                    <h5 class="card-title">User Profile</h5>
                                    <p class="card-text text-muted">Pengaturan Profil & Password Pengguna</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm mb-3">
                        @can('Akses-List')
                            <a href="{{ route('akses.index') }}" class="text-decoration-none">
                            @else
                                <a href="javascript:void(0)" class="text-decoration-none disabled"
                                    title="Anda tidak memiliki akses ke menu ini" style="cursor: not-allowed;">
                                @endcan
                                <div class="card shadow-sm h-100">
                                    <div class="card-body text-center">
                                        <img src="{{ asset('assets/images/data-protection.png') }}" alt="Agenda"
                                            class="mb-3" style="max-height: 50px;">
                                        <h5 class="card-title">Roles & Permissions</h5>
                                        <p class="card-text text-muted">Pengaturan Hak Akses</p>
                                    </div>
                                </div>
                            </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
