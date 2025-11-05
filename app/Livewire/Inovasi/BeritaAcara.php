<?php

namespace App\Livewire\Inovasi;

use App\Models\BeritaAcaraInovasi;
use App\Models\Inovasi;
use App\Models\InovasiMonitoring;
use App\Models\PeriodePengusulan;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class BeritaAcara extends Component
{
    use WithPagination, WithoutUrlPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $periode;
    public $selectedPeriode;
    public $selectedInovasi;
    public $beritaAcaraId;
    public $cariNamaInovasi = '';
    public $cariPengusul = '';

    public $cariSPI;
    public $dataUser1 = [];
    public $cariKepalaSPI;
    public $dataUser2 = [];
    public $cariPPE;
    public $dataUser3 = [];
    public $cariPPE2;
    public $dataUser4 = [];

    public $enablePeriode = true;
    public $formUpload = false;

    public $kebijakan = false;
    public $tek_kes = false;
    public $tek_si = false;
    public $pelayanan_publik = false;
    public $budaya_kerja = false;
    public $sop = false;
    public $mou = false;
    public $produk = false;
    public $pembaharuan = false;
    public $memudahkan = false;
    public $mempercepat = false;
    public $disebarluaskan = false;
    public $bermanfaat = false;
    public $spesifik = false;
    public $berkelanjutan = false;
    public $solusi = false;
    public $dapat_diaplikasikan = false;
    public $percontohan = false;
    public $perencanaan = false;
    public $pengukuran = false;
    public $pelaporan = false;
    public $evaluasi_akuntabilitas = false;
    public $dihargai = false;
    public $diadopsi = false;
    public $penilaian_percontohan = false;
    public $tidak_inovasi = false;

    public $keterangan_kebijakan, $keterangan_tek_kes, $keterangan_tek_si, $keterangan_pelayanan_publik,
        $keterangan_budaya_kerja, $keterangan_sop,  $keterangan_mou,  $keterangan_produk,  $keterangan_pembaharuan,
        $keterangan_memudahkan, $keterangan_mempercepat, $keterangan_disebarluaskan, $keterangan_bermanfaat, $keterangan_spesifik,
        $keterangan_berkelanjutan, $keterangan_solusi, $keterangan_dapat_diaplikasikan, $keterangan_percontohan,
        $keterangan_perencanaan, $keterangan_pengukuran, $keterangan_pelaporan, $keterangan_evaluasi_akuntabilitas,
        $tahun, $keterangan_tahun, $keterangan_sk, $keterangan_manual_book, $keterangan_laporan,
        $keterangan_tangkap_layar, $keterangan_matrik, $keterangan_hki, $keterangan_paten,
        $keterangan_penghargaan, $keterangan_dihargai, $keterangan_diadopsi, $keterangan_penilaian_percontohan,
        $keterangan_tidak_inovasi, $kesimpulan, $keterangan_bukti_lainnya, $keterangan_dokumen_lainnya;
    public $spi, $kepala_spi, $ppe_1, $ppe_2;
    public $jumlah_tahun, $jumlah_sk, $jumlah_manual_book, $jumlah_laporan, $jumlah_tangkap_layar, $jumlah_matrik, $jumlah_hki,
        $jumlah_paten, $jumlah_penghargaan, $jumlah_bukti_lainnya, $jumlah_dokumen_lainnya;

    protected function rules()
    {
        return [
            'kebijakan' => 'nullable|boolean',
            'tek_kes' => 'nullable|boolean',
            'tek_si' => 'nullable|boolean',
            'pelayanan_publik' => 'nullable|boolean',
            'budaya_kerja' => 'nullable|boolean',
            'sop' => 'nullable|boolean',
            'mou' => 'nullable|boolean',
            'produk' => 'nullable|boolean',
            'pembaharuan' => 'nullable|boolean',
            'memudahkan' => 'nullable|boolean',
            'mempercepat' => 'nullable|boolean',
            'disebarluaskan' => 'nullable|boolean',
            'bermanfaat' => 'nullable|boolean',
            'spesifik' => 'nullable|boolean',
            'berkelanjutan' => 'nullable|boolean',
            'solusi' => 'nullable|boolean',
            'dapat_diaplikasikan' => 'nullable|boolean',
            'percontohan' => 'nullable|boolean',
            'perencanaan' => 'nullable|boolean',
            'pengukuran' => 'nullable|boolean',
            'pelaporan' => 'nullable|boolean',
            'evaluasi_akuntabilitas' => 'nullable|boolean',
            'dihargai' => 'nullable|boolean',
            'diadopsi' => 'nullable|boolean',
            'penilaian_percontohan' => 'nullable|boolean',
            'tidak_inovasi' => 'nullable|boolean',
            'jumlah_tahun'    => 'nullable|numeric',
            'jumlah_sk'    => 'nullable|numeric',
            'jumlah_manual_book'    => 'nullable|numeric',
            'jumlah_laporan'    => 'nullable|numeric',
            'jumlah_tangkap_layar'    => 'nullable|numeric',
            'jumlah_matrik'    => 'nullable|numeric',
            'jumlah_hki'    => 'nullable|numeric',
            'jumlah_paten'    => 'nullable|numeric',
            'jumlah_penghargaan'    => 'nullable|numeric',
            'jumlah_bukti_lainnya'    => 'nullable|numeric',
            'jumlah_dokumen_lainnya'    => 'nullable|numeric',
            'tahun'    => 'required|numeric',
            'spi'    => 'required|numeric',
            'kepala_spi'    => 'required|numeric',
            'ppe_1'    => 'required|numeric',
            'ppe_2'    => 'nullable|numeric',
        ];
    }

    public function updatedCariSPI()
    {
        $this->dataUser1 = User::where('name', 'like', '%' . $this->cariSPI . '%')
            ->limit(5)
            ->orderBy('name', 'ASC')
            ->get();
    }
    public function updatedCariKepalaSPI()
    {
        $this->dataUser2 = User::where('name', 'like', '%' . $this->cariKepalaSPI . '%')
            ->limit(5)
            ->orderBy('name', 'ASC')
            ->get();
    }
    public function updatedCariPPE()
    {
        $this->dataUser3 = User::where('name', 'like', '%' . $this->cariPPE . '%')
            ->limit(5)
            ->orderBy('name', 'ASC')
            ->get();
    }
    public function updatedCariPPE2()
    {
        $this->dataUser4 = User::where('name', 'like', '%' . $this->cariPPE2 . '%')
            ->limit(5)
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function render()
    {
        $query = Inovasi::query();

        if ($this->cariNamaInovasi) {
            $query->where('judul', 'like', '%' . $this->cariNamaInovasi . '%');
        }

        if ($this->cariPengusul) {
            $query->whereHas('pengusul', function ($q) {
                $q->where('name', 'like', '%' . $this->cariPengusul . '%');
            });
        }

        if ($this->selectedPeriode == true) {
            $query->whereHas('periode', function ($q) {
                $q->where('tahun', $this->selectedPeriode);
            });
        }

        $data = $query->where('status', 'diterima')
            ->orderBy('created_at', 'DESC')->paginate(10);

        if ($this->selectedInovasi) {
            $detailInovasi = Inovasi::findOrFail($this->selectedInovasi);
        } else {
            $detailInovasi = null;
        }

        $dataUser = User::orderBy('name', 'ASC')->get();

        return view('livewire.inovasi.berita-acara', compact('data', 'detailInovasi', 'dataUser'));
    }

    public function mount()
    {
        $this->selectedPeriode = Carbon::now()->format('Y');
        $this->periode = PeriodePengusulan::orderBy('tahun', 'DESC')->get();
    }

    // Reset pagination setiap kali filter berubah
    public function updatingCariNamaInovasi()
    {
        $this->resetPage();
    }

    public function updatingCariPengusul()
    {
        $this->resetPage();
    }

    public function resetCari()
    {
        $this->reset('cariNamaInovasi', 'cariPengusul');
        $this->dispatch('resetCariFields');
    }

    public function tampilBA($id)
    {
        $this->selectedInovasi = $id;
        $this->formUpload = true;

        $cek = BeritaAcaraInovasi::where('inovasi_id', $id)->first();

        if ($cek) {
            $this->beritaAcaraId = $cek->id;
            $this->kebijakan = $cek->kebijakan;
            $this->tek_kes = $cek->tek_kes;
            $this->tek_si = $cek->tek_si;
            $this->pelayanan_publik = $cek->pelayanan_publik;
            $this->budaya_kerja = $cek->budaya_kerja;
            $this->sop = $cek->sop;
            $this->mou = $cek->mou;
            $this->produk = $cek->produk;
            $this->pembaharuan = $cek->pembaharuan;
            $this->memudahkan = $cek->memudahkan;
            $this->mempercepat = $cek->mempercepat;
            $this->disebarluaskan = $cek->disebarluaskan;
            $this->bermanfaat = $cek->bermanfaat;
            $this->spesifik = $cek->spesifik;
            $this->berkelanjutan = $cek->berkelanjutan;
            $this->solusi = $cek->solusi;
            $this->dapat_diaplikasikan = $cek->dapat_diaplikasikan;
            $this->percontohan = $cek->percontohan;
            $this->perencanaan = $cek->perencanaan;
            $this->pengukuran = $cek->pengukuran;
            $this->pelaporan = $cek->pelaporan;
            $this->evaluasi_akuntabilitas = $cek->evaluasi_akuntabilitas;
            $this->dihargai = $cek->dihargai;
            $this->diadopsi = $cek->diadopsi;
            $this->penilaian_percontohan = $cek->penilaian_percontohan;
            $this->tidak_inovasi = $cek->tidak_inovasi;
            $this->keterangan_kebijakan = $cek->keterangan_kebijakan;
            $this->keterangan_tek_kes = $cek->keterangan_tek_kes;
            $this->keterangan_tek_si = $cek->keterangan_tek_si;
            $this->keterangan_pelayanan_publik = $cek->keterangan_pelayanan_publik;
            $this->keterangan_budaya_kerja = $cek->keterangan_budaya_kerja;
            $this->keterangan_sop = $cek->keterangan_sop;
            $this->keterangan_mou = $cek->keterangan_mou;
            $this->keterangan_produk = $cek->keterangan_produk;
            $this->keterangan_pembaharuan = $cek->keterangan_pembaharuan;
            $this->keterangan_memudahkan = $cek->keterangan_memudahkan;
            $this->keterangan_mempercepat = $cek->keterangan_mempercepat;
            $this->keterangan_disebarluaskan = $cek->keterangan_disebarluaskan;
            $this->keterangan_bermanfaat = $cek->keterangan_bermanfaat;
            $this->keterangan_spesifik = $cek->keterangan_spesifik;
            $this->keterangan_berkelanjutan = $cek->keterangan_berkelanjutan;
            $this->keterangan_solusi = $cek->keterangan_solusi;
            $this->keterangan_dapat_diaplikasikan = $cek->keterangan_dapat_diaplikasikan;
            $this->keterangan_percontohan = $cek->keterangan_percontohan;
            $this->keterangan_perencanaan = $cek->keterangan_perencanaan;
            $this->keterangan_pengukuran = $cek->keterangan_pengukuran;
            $this->keterangan_pelaporan = $cek->keterangan_pelaporan;
            $this->keterangan_evaluasi_akuntabilitas = $cek->keterangan_evaluasi_akuntabilitas;
            $this->tahun = $cek->tahun;
            $this->keterangan_tahun = $cek->keterangan_tahun;
            $this->keterangan_sk = $cek->keterangan_sk;
            $this->keterangan_manual_book = $cek->keterangan_manual_book;
            $this->keterangan_laporan = $cek->keterangan_laporan;
            $this->keterangan_tangkap_layar = $cek->keterangan_tangkap_layar;
            $this->keterangan_matrik = $cek->keterangan_matrik;
            $this->keterangan_hki = $cek->keterangan_hki;
            $this->keterangan_paten = $cek->keterangan_paten;
            $this->keterangan_penghargaan = $cek->keterangan_penghargaan;
            $this->keterangan_dihargai = $cek->keterangan_dihargai;
            $this->keterangan_diadopsi = $cek->keterangan_diadopsi;
            $this->keterangan_penilaian_percontohan = $cek->keterangan_penilaian_percontohan;
            $this->keterangan_tidak_inovasi = $cek->keterangan_tidak_inovasi;
            $this->keterangan_dokumen_lainnya = $cek->keterangan_dokumen_lainnya;
            $this->keterangan_bukti_lainnya = $cek->keterangan_bukti_lainnya;
            $this->kesimpulan = $cek->kesimpulan;
            $this->spi = $cek->spi;
            $this->kepala_spi = $cek->kepala_spi;
            $this->ppe_1 = $cek->ppe_1;
            $this->ppe_2 = $cek->ppe_2;
            $this->jumlah_tahun = $cek->jumlah_tahun;
            $this->jumlah_sk = $cek->jumlah_sk;
            $this->jumlah_manual_book = $cek->jumlah_manual_book;
            $this->jumlah_laporan = $cek->jumlah_laporan;
            $this->jumlah_tangkap_layar = $cek->jumlah_tangkap_layar;
            $this->jumlah_matrik = $cek->jumlah_matrik;
            $this->jumlah_hki = $cek->jumlah_hki;
            $this->jumlah_paten = $cek->jumlah_paten;
            $this->jumlah_penghargaan = $cek->jumlah_penghargaan;
            $this->jumlah_bukti_lainnya = $cek->jumlah_bukti_lainnya;
            $this->jumlah_dokumen_lainnya = $cek->jumlah_dokumen_lainnya;

            $this->dataUser1 = User::find($this->spi) ? User::where('id', $this->spi)->get() : [];
            $this->dataUser2 = User::find($this->kepala_spi) ? User::where('id', $this->kepala_spi)->get() : [];
            $this->dataUser3 = User::find($this->ppe_1) ? User::where('id', $this->ppe_1)->get() : [];
            $this->dataUser4 = User::find($this->ppe_2) ? User::where('id', $this->ppe_2)->get() : [];
        }
    }

    public function tutupForm()
    {
        $this->reset(
            'selectedInovasi',
            'formUpload',
            'beritaAcaraId',
            'kebijakan',
            'keterangan_kebijakan',
            'tek_kes',
            'keterangan_tek_kes',
            'tek_si',
            'keterangan_tek_si',
            'pelayanan_publik',
            'keterangan_pelayanan_publik',
            'budaya_kerja',
            'keterangan_budaya_kerja',
            'sop',
            'keterangan_sop',
            'mou',
            'keterangan_mou',
            'produk',
            'keterangan_produk',
            'pembaharuan',
            'keterangan_pembaharuan',
            'memudahkan',
            'keterangan_memudahkan',
            'mempercepat',
            'keterangan_mempercepat',
            'disebarluaskan',
            'keterangan_disebarluaskan',
            'bermanfaat',
            'keterangan_bermanfaat',
            'spesifik',
            'keterangan_spesifik',
            'berkelanjutan',
            'keterangan_berkelanjutan',
            'solusi',
            'keterangan_solusi',
            'dapat_diaplikasikan',
            'keterangan_dapat_diaplikasikan',
            'percontohan',
            'keterangan_percontohan',
            'perencanaan',
            'keterangan_perencanaan',
            'pengukuran',
            'keterangan_pengukuran',
            'pelaporan',
            'keterangan_pelaporan',
            'evaluasi_akuntabilitas',
            'keterangan_evaluasi_akuntabilitas',
            'jumlah_tahun',
            'keterangan_tahun',
            'jumlah_sk',
            'keterangan_sk',
            'jumlah_manual_book',
            'keterangan_manual_book',
            'jumlah_laporan',
            'keterangan_laporan',
            'jumlah_tangkap_layar',
            'keterangan_tangkap_layar',
            'jumlah_matrik',
            'keterangan_matrik',
            'jumlah_hki',
            'keterangan_hki',
            'jumlah_paten',
            'keterangan_paten',
            'jumlah_penghargaan',
            'keterangan_penghargaan',
            'dihargai',
            'keterangan_dihargai',
            'diadopsi',
            'keterangan_diadopsi',
            'penilaian_percontohan',
            'keterangan_penilaian_percontohan',
            'tidak_inovasi',
            'keterangan_tidak_inovasi',
            'kesimpulan',
            'spi',
            'kepala_spi',
            'ppe_1',
            'ppe_2',
            'dataUser1',
            'dataUser2',
            'dataUser3',
            'dataUser4'
        );
    }

    public function simpan()
    {
        $this->validate();

        try {

            $simpan = BeritaAcaraInovasi::updateOrCreate(
                ['id' => $this->beritaAcaraId], // ← kunci pencarian (jika ada ID, maka update; jika tidak, create)
                [
                    'inovasi_id'        => $this->selectedInovasi,
                    'kebijakan'           => $this->kebijakan,
                    'keterangan_kebijakan'           => $this->keterangan_kebijakan,
                    'tek_kes'           => $this->tek_kes,
                    'keterangan_tek_kes'           => $this->keterangan_tek_kes,
                    'tek_si'           => $this->tek_si,
                    'keterangan_tek_si'           => $this->keterangan_tek_si,
                    'pelayanan_publik'           => $this->pelayanan_publik,
                    'keterangan_pelayanan_publik'           => $this->keterangan_pelayanan_publik,
                    'budaya_kerja'           => $this->budaya_kerja,
                    'keterangan_budaya_kerja'           => $this->keterangan_budaya_kerja,
                    'sop'           => $this->sop,
                    'keterangan_sop'           => $this->keterangan_sop,
                    'mou'           => $this->mou,
                    'keterangan_mou'           => $this->keterangan_mou,
                    'produk'           => $this->produk,
                    'keterangan_produk'           => $this->keterangan_produk,
                    'pembaharuan'           => $this->pembaharuan,
                    'keterangan_pembaharuan'           => $this->keterangan_pembaharuan,
                    'memudahkan'           => $this->memudahkan,
                    'keterangan_memudahkan'           => $this->keterangan_memudahkan,
                    'mempercepat'           => $this->mempercepat,
                    'keterangan_mempercepat'           => $this->keterangan_mempercepat,
                    'disebarluaskan'           => $this->disebarluaskan,
                    'keterangan_disebarluaskan'           => $this->keterangan_disebarluaskan,
                    'bermanfaat'           => $this->bermanfaat,
                    'keterangan_bermanfaat'           => $this->keterangan_bermanfaat,
                    'spesifik'           => $this->spesifik,
                    'keterangan_spesifik'           => $this->keterangan_spesifik,
                    'berkelanjutan'           => $this->berkelanjutan,
                    'keterangan_berkelanjutan'           => $this->keterangan_berkelanjutan,
                    'solusi'           => $this->solusi,
                    'keterangan_solusi'           => $this->keterangan_solusi,
                    'dapat_diaplikasikan'           => $this->dapat_diaplikasikan,
                    'keterangan_dapat_diaplikasikan'           => $this->keterangan_dapat_diaplikasikan,
                    'percontohan'           => $this->percontohan,
                    'keterangan_percontohan'           => $this->keterangan_percontohan,
                    'perencanaan'           => $this->perencanaan,
                    'keterangan_perencanaan'           => $this->keterangan_perencanaan,
                    'pengukuran'           => $this->pengukuran,
                    'keterangan_pengukuran'           => $this->keterangan_pengukuran,
                    'pelaporan'           => $this->pelaporan,
                    'keterangan_pelaporan'           => $this->keterangan_pelaporan,
                    'evaluasi_akuntabilitas'           => $this->evaluasi_akuntabilitas,
                    'keterangan_evaluasi_akuntabilitas'           => $this->keterangan_evaluasi_akuntabilitas,
                    'tahun'           => $this->tahun,
                    'jumlah_tahun'           => $this->jumlah_tahun,
                    'keterangan_tahun'           => $this->keterangan_tahun,
                    'jumlah_sk'           => $this->jumlah_sk,
                    'keterangan_sk'           => $this->keterangan_sk,
                    'jumlah_manual_book'           => $this->jumlah_manual_book,
                    'keterangan_manual_book'           => $this->keterangan_manual_book,
                    'jumlah_laporan'           => $this->jumlah_laporan,
                    'keterangan_laporan'           => $this->keterangan_laporan,
                    'jumlah_tangkap_layar'           => $this->jumlah_tangkap_layar,
                    'keterangan_tangkap_layar'           => $this->keterangan_tangkap_layar,
                    'jumlah_matrik'           => $this->jumlah_matrik,
                    'keterangan_matrik'           => $this->keterangan_matrik,
                    'jumlah_bukti_lainnya'           => $this->jumlah_bukti_lainnya,
                    'keterangan_bukti_lainnya'           => $this->keterangan_bukti_lainnya,
                    'jumlah_hki'           => $this->jumlah_hki,
                    'keterangan_hki'           => $this->keterangan_hki,
                    'jumlah_paten'           => $this->jumlah_paten,
                    'keterangan_paten'           => $this->keterangan_paten,
                    'jumlah_penghargaan'           => $this->jumlah_penghargaan,
                    'keterangan_penghargaan'           => $this->keterangan_penghargaan,
                    'jumlah_dokumen_lainnya'           => $this->jumlah_dokumen_lainnya,
                    'keterangan_dokumen_lainnya'           => $this->keterangan_dokumen_lainnya,
                    'dihargai'           => $this->dihargai,
                    'keterangan_dihargai'           => $this->keterangan_dihargai,
                    'diadopsi'           => $this->diadopsi,
                    'keterangan_diadopsi'           => $this->keterangan_diadopsi,
                    'penilaian_percontohan'           => $this->penilaian_percontohan,
                    'keterangan_penilaian_percontohan'           => $this->keterangan_penilaian_percontohan,
                    'tidak_inovasi'           => $this->tidak_inovasi,
                    'keterangan_tidak_inovasi'           => $this->keterangan_tidak_inovasi,
                    'kesimpulan'           => $this->kesimpulan,
                    'tanggal_ba'           => Carbon::now()->format('Y-m-d'),
                    'spi'           => $this->spi,
                    'kepala_spi'           => $this->kepala_spi,
                    'ppe_1'           => $this->ppe_1,
                    'ppe_2'           => $this->ppe_2,
                ]
            );

            $this->beritaAcaraId = $simpan->id;

            session()->flash('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function print($id)
    {
        $data = BeritaAcaraInovasi::findOrFail($id);
        $namaFile = Str::slug($data->inovasi->judul, '_') . '.pdf';

        // siapkan data yang akan dikirim ke view PDF
        $pdf = Pdf::loadView('inovasi.berita-acara-pdf', ['data' => $data])
            ->setPaper('a4', 'portrait');

        // langsung tampilkan PDF di browser
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'Berita_Acara_' . $namaFile);
    }

    public function hapusFile($id)
    {
        $monitoring = InovasiMonitoring::findOrFail($id);

        // cek kalau ada file
        if ($monitoring->file_path && Storage::disk('public')->exists($monitoring->file_path)) {
            Storage::disk('public')->delete($monitoring->file_path);
        }

        // hapus record database
        $monitoring->delete();

        session()->flash('success', 'File berhasil dihapus.');
    }
}
