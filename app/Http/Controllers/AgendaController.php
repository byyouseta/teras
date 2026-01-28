<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Gambar;
use App\Models\Tamu;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class AgendaController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    public function index(Request $request)
    {
        return view('agenda.agenda');
    }

    public function dashboard(Request $request)
    {
        $dataAgenda = Agenda::all();

        $bulanIni = Carbon::now();
        $bulanLalu = Carbon::now()->subMonth();

        // dd($bulanIni->month, $bulanIni->year, $bulanLalu->month, $bulanLalu->year);

        $agendaBulanIni = Agenda::whereMonth('created_at', $bulanIni->month)
            ->whereYear('created_at', $bulanIni->year)
            ->get();

        $agendaBulanLalu = Agenda::whereMonth('created_at', $bulanLalu->month)
            ->whereYear('created_at', $bulanLalu->year)
            ->get();

        return view('agenda.index', compact('dataAgenda', 'agendaBulanIni', 'agendaBulanLalu'));
    }

    public function detail(Request $request)
    {
        return view('agenda.detail');
    }

    public function notulen($id)
    {
        $agenda = Agenda::findOrFail(Crypt::decrypt($id));

        // dd($agenda);

        if (!$agenda->notulen || !Storage::disk('public')->exists('agenda/notulen/' . $agenda->notulen)) {
            abort(404);
        }

        return response()->file(storage_path('app/public/agenda/notulen/' . $agenda->notulen));
    }

    public function daftar($id)
    {
        $agenda = Agenda::findOrFail(Crypt::decrypt($id));

        // dd($agenda);

        if (!$agenda->daftar || !Storage::disk('public')->exists('agenda/daftarHadir/' . $agenda->daftar)) {
            abort(404);
        }

        return response()->file(storage_path('app/public/agenda/daftarHadir/' . $agenda->daftar));
    }

    public function materi($id)
    {
        $agenda = Agenda::findOrFail(Crypt::decrypt($id));

        // dd($agenda);

        if (!$agenda->materi || !Storage::disk('public')->exists('agenda/materi/' . $agenda->materi)) {
            abort(404);
        }

        return response()->file(storage_path('app/public/agenda/materi/' . $agenda->materi));
    }

    public function dokumentasi($id)
    {
        $gambar = Gambar::findOrFail(Crypt::decrypt($id));

        // dd($agenda);

        if (!$gambar || !Storage::disk('public')->exists('agenda/dokumentasi/' . $gambar->gambar)) {
            abort(404);
        }

        return response()->file(storage_path('app/public/agenda/dokumentasi/' . $gambar->gambar));
    }

    public function viewUndangan($filename)
    {
        $path = "agenda/undangan/{$filename}";

        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->file(
            Storage::disk('public')->path($path),
            ['Content-Type' => 'application/pdf']
        );
    }

    public function viewDaftarHadir($filename)
    {
        $path = "agenda/daftarHadir/{$filename}";

        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->file(
            Storage::disk('public')->path($path),
            ['Content-Type' => 'application/pdf']
        );
    }

    public function undangan($id)
    {
        $agenda = Agenda::findOrFail(Crypt::decrypt($id));

        // LANGKAH 1: PERIKSA OUTPUT HTML MENTAH
        // Hapus atau komentari baris di bawah ini setelah Anda berhasil memastikan HTML-nya benar.
        // return view('agenda.undangan-pdf', compact('agenda'));

        // LANGKAH 2: EKSEKUSI PDF SEPERTI BIASA
        $f4 = [0, 0, 595.28, 935.43];

        $pdf = Pdf::loadView('agenda.undangan-pdf', compact('agenda'))
            ->setPaper($f4, 'portrait')
            // ... (opsi lainnya)
            ->setOption('defaultFont', 'sans-serif');

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="preview.pdf"');
    }

    public function daftarHadir($id)
    {
        $agenda = Agenda::findOrFail(Crypt::decrypt($id));

        $peserta = $agenda->user()
            ->wherePivot('presensi_at', '!=', '')
            ->get();

        $tamu = Tamu::where('agenda_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        // LANGKAH 1: PERIKSA OUTPUT HTML MENTAH
        // Hapus atau komentari baris di bawah ini setelah Anda berhasil memastikan HTML-nya benar.
        // return view('agenda.undangan-pdf', compact('agenda'));

        // LANGKAH 2: EKSEKUSI PDF SEPERTI BIASA
        $f4 = [0, 0, 595.28, 935.43];

        $pdf = Pdf::loadView('agenda.daftarhadir-pdf', compact('agenda', 'peserta', 'tamu'))
            ->setPaper($f4, 'portrait')
            // ... (opsi lainnya)
            ->setOption('defaultFont', 'sans-serif');

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="preview.pdf"');
    }

    public function presensi(Request $request)
    {
        return view('agenda.presensi');
    }
}
