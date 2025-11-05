<?php

namespace App\Livewire\Inovasi;

use App\Models\PeriodePengusulan;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class PeriodeInovasi extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';

    public $cariPeriode;
    public $namaPeriode, $tahun, $mulai, $selesai;
    public $status = 'open';
    public $periodeId;
    public $idYangAkanDihapus;
    public $modalTitle = 'Tambah Data';

    protected $rules = [
        'namaPeriode' => 'required|string|max:255',
        'tahun' => 'required',
        'mulai' => 'required|date',
        'selesai' => 'required|date|after_or_equal:mulai',
        'status' => 'required'
    ];

    public function mount()
    {
        $this->tahun = Carbon::now()->format('Y');
    }

    public function render()
    {
        $query = PeriodePengusulan::query();

        if ($this->cariPeriode) {
            $query->where('tahun', 'like', '%' . $this->cariPeriode . '%');
        }

        $data = $query->orderBy('tahun', 'ASC')->paginate(10);

        return view('livewire.inovasi.periode-inovasi', compact('data'));
    }

    public function updatingCariUnit()
    {
        $this->resetPage();
    }

    public function simpan()
    {
        $this->authorize('Akses-Operator-Create');

        $this->validate();

        // cek overlap periode di tahun yang sama
        $overlap = PeriodePengusulan::where('tahun', $this->tahun)
            ->where(function ($q) {
                $q->whereBetween('mulai', [$this->mulai, $this->selesai])
                    ->orWhereBetween('selesai', [$this->mulai, $this->selesai])
                    ->orWhere(function ($q2) {
                        $q2->where('mulai', '<=', $this->mulai)
                            ->where('selesai', '>=', $this->selesai);
                    });
            })
            ->when($this->periodeId ?? null, function ($q) {
                // kalau edit, exclude dirinya sendiri
                $q->where('id', '!=', $this->periodeId);
            })
            ->exists();

        if ($overlap) {
            throw ValidationException::withMessages([
                'mulai' => 'Periode tanggal ini sudah bertabrakan dengan periode lain.',
                'selesai' => 'Periode tanggal ini sudah bertabrakan dengan periode lain.',
            ]);
        }

        $simpanUnit = PeriodePengusulan::updateOrCreate(
            ['id' => $this->periodeId],
            [
                'nama_periode' => $this->namaPeriode,
                'mulai' => Carbon::parse($this->mulai)->format('Y-m-d'),
                'selesai' => Carbon::parse($this->selesai)->format('Y-m-d'),
                'status' => $this->status,
                'tahun' => $this->tahun
            ]
        );

        if ($simpanUnit) {
            session()->flash('success', 'Data berhasil disimpan.');
            $this->resetFormInput();
        } else {
            session()->flash('error', 'Data gagal disimpan.');
        }
    }

    public function edit($id)
    {
        $this->authorize('Akses-Operator-Update');

        $data = PeriodePengusulan::findOrFail($id);

        $this->periodeId = $id;
        $this->namaPeriode = $data->nama_periode;
        $this->tahun = $data->tahun;
        $this->mulai = $data->mulai;
        $this->selesai = $data->selesai;
        $this->status = $data->status;

        // dd($this->status);

        $this->modalTitle = 'Edit Data';
        $this->dispatch('bukaModalEdit');
    }

    public function hapus()
    {
        $this->authorize('Akses-Operator-Delete');

        $hapus = PeriodePengusulan::find($this->idYangAkanDihapus);

        if ($hapus) {
            $hapus->delete();
            session()->flash('success', 'Data berhasil dihapus.');
        } else {
            session()->flash('error', 'Data tidak ditemukan.');
        }

        // Reset agar tidak terhapus dua kali secara tak sengaja
        $this->reset('idYangAkanDihapus');

        // Emit JS untuk menutup modal
        $this->dispatch('tutupModalHapus');
    }

    public function resetCari()
    {
        $this->reset('cariPeriode');
        $this->dispatch('resetCariFields');
    }

    public function bukaModal()
    {
        $this->dispatch('show-add-modal');
    }

    public function tutupModal()
    {
        $this->reset('periodeId', 'namaPeriode', 'tahun', 'mulai', 'selesai', 'status', 'modalTitle');
        $this->dispatch('hide-modal');
    }

    public function resetFormInput()
    {
        $this->reset('periodeId', 'namaPeriode', 'tahun', 'mulai', 'selesai', 'status', 'modalTitle');
        $this->dispatch('hide-modal');
    }
}
