<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AksesController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\EtikaController;
use App\Http\Controllers\InovasiController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Agenda\Detail;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Models\Inovasi;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('front');
});

// Route::get('/phpinfo', function () {
//     return view('phpinfo');
// });

Route::get('/login', Login::class)->name('login');
// Route::get('/register', Register::class)->name('register');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/main', function () {
    return view('main');
})->middleware(['auth', 'verified'])->name('main');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route::get('/agenda/{id}/detail', Detail::class)->name('agenda.detail');
    Route::get('/profile-image/{filename}', function ($filename) {
        $path = storage_path('app/public/profile/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        return response($file, 200)->header("Content-Type", $type);
    })->name('profile.image');
});

//Middleware Auth dicontroller saja
Route::get('/agenda/dashboard', [AgendaController::class, 'dashboard'])->name('agenda.dashboard');
Route::get('/agenda/daftar', [AgendaController::class, 'index'])->name('agenda.list');
Route::get('/agenda/{id}/detail', [AgendaController::class, 'detail'])->name('agenda.detail');
Route::get('/agenda/detail/{id}/notulen', [AgendaController::class, 'notulen'])->name('agenda.notulen');
Route::get('/agenda/detail/{id}/daftar', [AgendaController::class, 'daftar'])->name('agenda.daftar');
Route::get('/agenda/detail/{id}/materi', [AgendaController::class, 'materi'])->name('agenda.materi');
Route::get('/agenda/detail/{id}/dokumentasi', [AgendaController::class, 'dokumentasi'])->name('agenda.dokumentasi');
Route::get('/agenda/detail/{id}/undangan', [AgendaController::class, 'undangan'])->name('agenda.undangan');
Route::get('/agenda/detail/{id}/hadir', [AgendaController::class, 'daftarHadir'])->name('agenda.hadir');
Route::get('/agenda/undangan/{filename}', [AgendaController::class, 'viewUndangan'])
    ->name('agenda.viewUndangan');
Route::get('/agenda/daftar-hadir/{filename}', [AgendaController::class, 'viewDaftarHadir'])
    ->name('agenda.viewDaftarHadir');
Route::get('/agenda/presensi', [AgendaController::class, 'presensi'])->name('agenda.presensi');

Route::get('/etika/pelaporan', [EtikaController::class, 'pelaporan'])->name('etika.pelaporan')->middleware('throttle:5,1');
Route::middleware('auth')->group(function () {
    Route::get('/etika/tindaklanjut', [EtikaController::class, 'tindaklanjut'])->name('etika.tindaklanjut');
    Route::get('/etika', [EtikaController::class, 'main'])->name('etika.main');
    Route::get('/etika/download/{file}', [EtikaController::class, 'download'])->name('etika.file.pendukung');
    Route::get('/etika/rtl/{file}', [EtikaController::class, 'fileRtl'])->name('etika.file.tindak.lanjut');
});

Route::get('/master/unit', [MasterController::class, 'masterUnit'])->name('master.unit');
Route::get('/master/pegawai', [MasterController::class, 'masterPegawai'])->name('master.pegawai');
Route::get('/master/ruangan', [MasterController::class, 'masterRuangan'])->name('master.ruangan');
Route::get('/master/users', [MasterController::class, 'masterUsers'])->name('master.users');
Route::get('/master/logs', [MasterController::class, 'logUsers'])->name('master.logusers');

//Modul Inovasi
Route::get('/inovasi/index', [InovasiController::class, 'index'])->name('inovasi.index');
Route::get('/inovasi/daftar', [InovasiController::class, 'list'])->name('inovasi.list');
Route::get('/inovasi/periode', [InovasiController::class, 'periode'])->name('inovasi.periode');
Route::get('/inovasi/pengajuan', [InovasiController::class, 'pengajuan'])->name('inovasi.pengajuan');
Route::get('/inovasi/status', [InovasiController::class, 'status'])->name('inovasi.status');
Route::get('/inovasi/persetujuan', [InovasiController::class, 'persetujuan'])->name('inovasi.persetujuan');
Route::get('/inovasi/paparan', [InovasiController::class, 'paparan'])->name('inovasi.paparan');
Route::get('/inovasi/monitoring', [InovasiController::class, 'monitoring'])->name('inovasi.monitoring');
Route::get('/inovasi/beritaacara', [InovasiController::class, 'beritaAcara'])->name('inovasi.beritaacara');
Route::get('/inovasi/{id}/proposal', [InovasiController::class, 'showProposal'])->name('inovasi.proposal.show');
Route::get('/inovasi/{id}/file', [InovasiController::class, 'showFile'])->name('inovasi.file.show');
Route::get('/inovasi/berita-acara/{id}/print', [InovasiController::class, 'print'])
    ->name('inovasi.print.berita.acara');

Route::get('/akses/index', [AksesController::class, 'index'])->name('akses.index');
Route::get('/akses/permission', [AksesController::class, 'permission'])->name('akses.permission');
Route::get('/akses/roles', [AksesController::class, 'role'])->name('akses.roles');

// require __DIR__ . '/auth.php';
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');
