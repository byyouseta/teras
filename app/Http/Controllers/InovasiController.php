<?php

namespace App\Http\Controllers;

use App\Models\BeritaAcaraInovasi;
use App\Models\Inovasi;
use App\Models\InovasiMonitoring;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InovasiController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    public function index(Request $request)
    {
        $inovasi = Inovasi::all();

        $tahunIni = Carbon::now()->year;
        $tahunLalu = Carbon::now()->subYear()->year;

        $inovasiTahunIni = Inovasi::where('status', '!=', 'draft')
            ->whereHas('periode', fn($q) => $q->where('tahun', $tahunIni))
            ->get();

        $inovasiTahunLalu = Inovasi::where('status', '!=', 'draft')
            ->whereHas('periode', fn($q) => $q->where('tahun', $tahunLalu))
            ->get();

        // hitung persentase kenaikan
        if ($inovasiTahunLalu->count() > 0) {

            $totalLalu      = $inovasiTahunLalu->count();
            $totalIni       = $inovasiTahunIni->count();

            $diajukanLalu   = $inovasiTahunLalu->where('status', 'diajukan')->count();
            $diterimaLalu   = $inovasiTahunLalu->where('status', 'diterima')->count();
            $ditolakLalu    = $inovasiTahunLalu->where('status', 'ditolak')->count();

            $diajukanIni    = $inovasiTahunIni->where('status', 'diajukan')->count();
            $diterimaIni    = $inovasiTahunIni->where('status', 'diterima')->count();
            $ditolakIni     = $inovasiTahunIni->where('status', 'ditolak')->count();

            // helper aman
            $hitungPersen = function ($lalu, $ini) {
                if ($lalu == 0) {
                    return $ini > 0 ? 100 : 0;
                }
                return round((($ini - $lalu) / $lalu) * 100, 2);
            };

            $persentaseTotal    = $hitungPersen($totalLalu, $totalIni);
            $persentaseDiajukan = $hitungPersen($diajukanLalu, $diajukanIni);
            $persentaseDiterima = $hitungPersen($diterimaLalu, $diterimaIni);
            $persentaseDitolak  = $hitungPersen($ditolakLalu, $ditolakIni);
        } else {
            // kalau tahun lalu 0, berarti semua dianggap kenaikan penuh
            $persentaseTotal = $inovasiTahunIni->count() > 0 ? 100 : 0;
            $persentaseDiajukan = $inovasiTahunIni->count() > 0 ? 100 : 0;
            $persentaseDiterima = $inovasiTahunIni->count() > 0 ? 100 : 0;
            $persentaseDitolak = $inovasiTahunIni->count() > 0 ? 100 : 0;
        }

        return view('inovasi.index', compact('inovasi', 'inovasiTahunIni', 'inovasiTahunLalu', 'persentaseTotal', 'persentaseDiajukan', 'persentaseDiterima', 'persentaseDitolak'));
    }

    public function list(Request $request)
    {
        return view('inovasi.list');
    }

    public function periode(Request $request)
    {
        return view('inovasi.periode');
    }

    public function pengajuan(Request $request)
    {
        return view('inovasi.pengajuan');
    }

    public function status(Request $request)
    {
        return view('inovasi.status');
    }

    public function persetujuan(Request $request)
    {
        return view('inovasi.persetujuan');
    }

    public function paparan(Request $request)
    {
        return view('inovasi.paparan');
    }

    public function monitoring(Request $request)
    {
        return view('inovasi.monitoring');
    }

    public function beritaAcara(Request $request)
    {
        return view('inovasi.beritaacara');
    }

    public function showProposal($id)
    {
        $inovasi = Inovasi::findOrFail(Crypt::decrypt($id));

        if (!$inovasi->proposal_word || !Storage::disk('public')->exists($inovasi->proposal_word)) {
            abort(404);
        }

        return response()->file(storage_path('app/public/' . $inovasi->proposal_word));
    }

    public function showFile($id)
    {
        $file = InovasiMonitoring::findOrFail(Crypt::decrypt($id));

        if (!$file->dokumen || !Storage::disk('public')->exists($file->dokumen)) {
            abort(404);
        }

        return response()->file(storage_path('app/public/' . $file->dokumen));
    }

    public function print($id)
    {
        // Ambil data berita acara berdasarkan ID
        $cek = Inovasi::findOrFail($id);
        $data = BeritaAcaraInovasi::where('inovasi_id', $cek->id)->first();

        if (!$data) {
            abort(404, 'Berita Acara tidak ditemukan.');
        }

        $kategoriMap = [
            'perencanaan' => 'Perencanaan',
            'pemanfaatan_perencanaan' => 'Pemanfaatan Perencanaan',
            'pengukuran' => 'Pengukuran',
            'pemanfaatan_pengukuran' => 'Pemanfaatan Pengukuran',
            'pelaporan' => 'Pelaporan',
            'pemanfaatan_pelaporan' => 'Pemanfaatan Pelaporan',
            'evaluasi_akuntabilitas' => 'Evaluasi Akuntabilitas',
            'pemanfaatan_evaluasi_akuntabilitas' => 'Pemanfaatan Evaluasi Akuntabilitas',
        ];

        $dataLaporan = [];

        foreach ($kategoriMap as $field => $label) {
            if ($data->$field) {
                $dataLaporan[] = [
                    'kategori' => $label,
                    'key' => $field,
                    'data' => $data,
                ];
            }
        }

        $namaFile = Str::slug($data->inovasi->judul, '_') . '.pdf';

        // Buat PDF dari view
        $pdf = Pdf::loadView('inovasi.berita-acara-pdf', compact('dataLaporan'))
            ->setPaper('a4', 'portrait');

        // Stream hasil PDF ke browser (buka di tab baru)
        return $pdf->stream('berita_acara_' . $namaFile);
    }
}
