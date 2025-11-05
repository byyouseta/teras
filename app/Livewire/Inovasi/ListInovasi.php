<?php

namespace App\Livewire\Inovasi;

use App\Models\Agenda;
use App\Models\Inovasi;
use App\Models\PeriodePengusulan;
use App\Models\Ruangan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ListInovasi extends Component
{
    use WithPagination, WithoutUrlPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $periode;
    public $selectedPeriode;
    public $cariNamaInovasi = '';
    public $cariPengusul = '';

    public $bukaDetail = false;
    public $selectedInovasi;

    public $enablePeriode = true;

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

        if ($this->selectedPeriode) {
            $query->whereHas('periode', function ($q) {
                $q->where('tahun', $this->selectedPeriode);
            });
        }

        $data = $query->whereIn('status', ['diterima', 'ditolak'])
            ->orderBy('created_at', 'DESC')->paginate(10);
        if ($this->selectedInovasi) {
            $detailInovasi = Inovasi::findOrFail($this->selectedInovasi);
        } else {
            $detailInovasi = null;
        }

        return view('livewire.inovasi.list-inovasi', compact('data', 'detailInovasi'));
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

    // public function updatedCariPengusul()
    // {
    //     $this->dataPengundang = User::where('name', 'like', '%' . $this->cariPengusul . '%')
    //         ->orderBy('name', 'ASC')
    //         ->get();
    // }

    public function enableStatusPeriode()
    {
        $this->enablePeriode = !$this->enablePeriode;
    }

    public function resetCari()
    {
        $this->reset('cariNamaInovasi', 'cariPengusul');
        $this->dispatch('resetCariFields');
    }

    public function detailInovasi($id)
    {
        $this->selectedInovasi = $id;

        $this->bukaDetail = true;
    }

    public function bukaModal()
    {
        $this->bukaDetail = true;

        $this->dispatch('show-add-modal');
    }

    public function tutupDetail()
    {
        $this->bukaDetail = false;

        // $this->reset('cariNamaInovasi', 'cariPengundang');
        // $this->dataRuangan = $this->defaultDataRuangan;
        // $this->dataPengundang = $this->defaultDataPengundang;
        // $this->dispatch('hide-modal');
    }

    public function hapusInovasi()
    {
        $cariInovasi = Inovasi::find($this->idYangAkanDihapus);

        if ($cariInovasi) {
            $cariInovasi->delete();
            session()->flash('success', 'Data berhasil dihapus.');
        } else {
            session()->flash('error', 'Data tidak ditemukan.');
        }

        // Reset agar tidak terhapus dua kali secara tak sengaja
        $this->reset('idYangAkanDihapus');

        // Emit JS untuk menutup modal
        $this->dispatch('tutupModalHapus');
    }

    public function resetFormInput()
    {
        $this->reset('cariNamaInovasi', 'cariPengundang');
        // $this->dataRuangan = $this->defaultDataRuangan;
        // $this->dataPengundang = $this->defaultDataPengundang;
        $this->dispatch('agendaDisimpan');
    }
}
