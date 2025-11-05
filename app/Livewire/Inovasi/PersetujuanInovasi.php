<?php

namespace App\Livewire\Inovasi;

use App\Models\ApprovalInovasi;
use App\Models\Inovasi;
use App\Models\PeriodePengusulan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class PersetujuanInovasi extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';

    public $periode;
    public $selectedPeriode;
    public $selectedInovasi;
    public $cariNamaInovasi = '';
    public $cariPengusul = '';
    public $bukaDetail = false;

    public $status, $catatan, $approvalId;

    public $openFormModal = false;

    public $enablePeriode = true;

    public function rules()
    {
        return [
            'status' => 'required',
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

        $data = $query->whereHas('approvals', function ($q) {
            $q->where('user_id', Auth::user()->id);
        })
            ->where('status', '!=', 'draft')
            ->orderBy('created_at', 'DESC')->paginate(10);

        if ($this->selectedInovasi) {
            $detailInovasi = Inovasi::findOrFail($this->selectedInovasi);
        } else {
            $detailInovasi = null;
        }

        return view('livewire.inovasi.persetujuan-inovasi', compact('data', 'detailInovasi'));
    }

    public function mount()
    {
        $this->selectedPeriode = Carbon::now()->format('Y');
        $this->periode = PeriodePengusulan::orderBy('tahun', 'DESC')->get();
    }

    public function selectApproval($id)
    {
        $approve = ApprovalInovasi::findOrFail($id);

        $this->approvalId = $id;
        $this->status = $approve->status;
        $this->catatan = $approve->catatan;

        $this->dispatch('bukaModalApproval');
    }

    public function simpanApproval()
    {
        $this->validate();

        $approve = ApprovalInovasi::findOrFail($this->approvalId);

        if ($approve) {
            $approve->status = $this->status;
            $approve->catatan = $this->catatan;
            $approve->save();

            if ($this->status == 'rejected') {
                $inovasi = Inovasi::find($approve->inovasi_id);
                $inovasi->status = 'ditolak';
                $inovasi->save();
            }
            session()->flash('success', 'Inovasi berhasil disimpan!');
        } else {
            session()->flash('success', 'Inovasi berhasil disimpan!');
        }

        $this->tutupModal();
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

    public function detailInovasi($id)
    {
        $this->selectedInovasi = $id;

        $this->bukaDetail = true;
    }

    public function tutupDetail()
    {
        $this->reset('selectedInovasi');

        $this->bukaDetail = false;
    }

    public function resetCari()
    {
        $this->reset('cariNamaInovasi', 'cariPengusul');
        $this->dispatch('resetCariFields');
    }

    public function bukaModal()
    {
        $this->openFormModal = true;

        $this->dispatch('show-add-modal');
    }

    public function tutupModal()
    {
        // $this->reset('cariNamaInovasi', 'cariPengundang');
        // $this->dataRuangan = $this->defaultDataRuangan;
        // $this->dataPengundang = $this->defaultDataPengundang;
        $this->dispatch('hide-modal');
    }
}
