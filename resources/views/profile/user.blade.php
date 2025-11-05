@extends('layouts.mantis_nosidebar')
@section('header-title')
    Profile User
@endsection
@section('content')
    <div class="col-sm-8">
        <ul class="nav nav-pills nav-fill mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                    type="button" role="tab" aria-controls="pills-home" aria-selected="true">
                    <i class="ti ti-user"></i> Profil
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-password-tab" data-bs-toggle="pill" data-bs-target="#pills-password"
                    type="button" role="tab" aria-controls="pills-password" aria-selected="false">
                    <i class="ti ti-lock"></i> Ubah Password
                </button>
            </li>
            {{-- <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-setting-tab" data-bs-toggle="pill" data-bs-target="#pills-setting"
                    type="button" role="tab" aria-controls="pills-setting" aria-selected="false">
                    Pengaturan
                </button>
            </li> --}}
        </ul>

        <div class="tab-content mb-3" id="pills-tabContent">
            <!-- Tab Profil -->
            <div class="tab-pane fade show active p-3 border rounded bg-white" id="pills-home" role="tabpanel"
                aria-labelledby="pills-home-tab" tabindex="0">
                <h5>Profil Pengguna</h5>
                <p>Isi form atau informasi profil pengguna di sini.</p>
                @livewire('master.profile-user', ['user' => $user])

            </div>

            <!-- Tab Password -->
            <div class="tab-pane fade p-3 border rounded bg-white" id="pills-password" role="tabpanel"
                aria-labelledby="pills-password-tab" tabindex="0">
                <h5>Ubah Password</h5>
                <p>Ganti password lama dengan yang baru untuk keamanan akun.</p>
                @livewire('master.password-user')
            </div>

            <!-- Tab Setting -->
            {{-- <div class="tab-pane fade p-3 border rounded bg-white" id="pills-setting" role="tabpanel"
                aria-labelledby="pills-setting-tab" tabindex="0">
                <h5>Pengaturan</h5>
                <p>Tambahkan konfigurasi lain di sini, seperti preferensi tampilan atau notifikasi.</p>
            </div> --}}
        </div>

    </div>
@endsection
