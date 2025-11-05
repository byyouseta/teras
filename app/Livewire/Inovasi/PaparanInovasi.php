<?php

namespace App\Livewire\Inovasi;

use App\Models\Inovasi;
use App\Models\PengujiInovasi;
use App\Models\PeriodePengusulan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class PaparanInovasi extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';

    public $periode;
    public $selectedPeriode;
    public $selectedInovasi;
    public $cariNamaInovasi = '';
    public $cariPengusul = '';
    public $bukaDetail = false;
    public $formKesimpulan = false;

    public $orisinilModifikasi, $memudahkanPelayanan, $mempercepatPelayanan, $solusi, $manfaat, $aplikasi, $simpulan, $catatan;
    #[Validate('required')]
    public $statusFinal;

    public $enablePeriode = true;

    public function rules()
    {
        return [
            'orisinilModifikasi' => 'required',
            'memudahkanPelayanan' => 'required',
            'mempercepatPelayanan' => 'required',
            'solusi' => 'required',
            'manfaat' => 'required',
            'aplikasi' => 'required',
            'simpulan' => 'required',
            'catatan' => 'nullable',
        ];
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

        $data = $query->whereHas('pengujis', function ($q) {
            $q->where('user_id', Auth::user()->id);
        })
            ->whereHas('jadwalPresentasi', function ($q) {
                $q->where('tanggal_presentasi', '!=', null);
            })
            // ->where('status', 'dijadwalkan')
            ->orderBy('created_at', 'DESC')->paginate(10);

        if ($this->selectedInovasi) {
            $detailInovasi = Inovasi::findOrFail($this->selectedInovasi);
            $this->statusFinal = $detailInovasi->status;
        } else {
            $detailInovasi = null;
        }

        return view('livewire.inovasi.paparan-inovasi', compact('data', 'detailInovasi'));
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

    public function detailInovasi($id)
    {
        $this->formKesimpulan = false;
        $this->selectedInovasi = $id;

        $penilaian = PengujiInovasi::where('inovasi_id', $this->selectedInovasi)
            ->where('user_id', Auth::user()->id)
            ->first();

        if ($penilaian) {
            $this->orisinilModifikasi = $penilaian->orisinil_modifikasi;
            $this->memudahkanPelayanan = $penilaian->memudahkan_pelayanan;
            $this->mempercepatPelayanan = $penilaian->mempercepat_pelayanan;
            $this->solusi = $penilaian->solusi_masalah;
            $this->manfaat = $penilaian->manfaat;
            $this->aplikasi = $penilaian->aplikasi_internal_eksternal;
            $this->simpulan = $penilaian->simpulan;
            $this->catatan = $penilaian->catatan;
        }


        $this->bukaDetail = true;
    }

    public function tutupDetail()
    {
        $this->reset('selectedInovasi');
        $this->reset('orisinilModifikasi', 'memudahkanPelayanan', 'mempercepatPelayanan', 'solusi', 'manfaat', 'aplikasi', 'simpulan', 'catatan');

        $this->bukaDetail = false;
    }

    public function simpan()
    {
        $this->validate();

        $simpanPenilaian = PengujiInovasi::where('inovasi_id', $this->selectedInovasi)
            ->where('user_id', Auth::user()->id)
            ->first();

        $simpanPenilaian->orisinil_modifikasi = $this->orisinilModifikasi;
        $simpanPenilaian->memudahkan_pelayanan = $this->memudahkanPelayanan;
        $simpanPenilaian->mempercepat_pelayanan = $this->mempercepatPelayanan;
        $simpanPenilaian->solusi_masalah = $this->solusi;
        $simpanPenilaian->manfaat = $this->manfaat;
        $simpanPenilaian->aplikasi_internal_eksternal = $this->aplikasi;
        $simpanPenilaian->simpulan = $this->simpulan;
        $simpanPenilaian->catatan = $this->catatan;
        $simpanPenilaian->save();

        if ($simpanPenilaian) {
            session()->flash('success', 'Penilaian berhasil disimpan.');
        } else {
            session()->flash('error', 'Ada kegagalan dalam menyimpan data.');
        }
    }

    public function kesimpulanInovasi($id)
    {
        $this->selectedInovasi = $id;

        $this->formKesimpulan = true;
        $this->bukaDetail = false;
    }

    public function tutupKesimpulan()
    {
        $this->reset('selectedInovasi', 'statusFinal');

        $this->formKesimpulan = false;
    }

    public function simpanStatus()
    {
        $this->validate([
            'statusFinal' => 'required',
        ]);

        $set = Inovasi::find($this->selectedInovasi);
        $set->status = $this->statusFinal;
        $set->save();
        // dd($this->selectedInovasi);

        if ($set) {

            session()->flash('success', 'Data berhasil disimpan.');
        } else {
            session()->flash('error', 'Ada kegagalan dalam menyimpan data.');
        }
    }
}
