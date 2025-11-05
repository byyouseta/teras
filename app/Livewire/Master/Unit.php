<?php

namespace App\Livewire\Master;

use App\Models\Unit as ModelsUnit;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Unit extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';

    public $cariUnit;
    public $namaUnit, $keterangan;
    public $unitId;
    public $idYangAkanDihapus;
    public $modalTitle = 'Tambah Data';

    protected $rules = [
        'namaUnit' => 'required|string|max:255',
        'keterangan' => 'nullable|string|max:255',
    ];

    public function render()
    {
        $query = ModelsUnit::query();

        if ($this->cariUnit) {
            $query->where('nama_unit', 'like', '%' . $this->cariUnit . '%');
        }

        $data = $query->orderBy('nama_unit', 'ASC')->paginate(10);

        return view('livewire.master.unit', compact('data'));
    }

    public function updatingCariUnit()
    {
        $this->resetPage();
    }

    public function simpan()
    {
        $this->validate();

        $simpanUnit = ModelsUnit::updateOrCreate(
            ['id' => $this->unitId],
            [
                'nama_unit' => $this->namaUnit,
                'keterangan' => $this->keterangan
            ]
        );

        if ($simpanUnit) {
            session()->flash('success', 'Unit berhasil disimpan.');
            $this->resetFormInput();
        } else {
            session()->flash('error', 'Unit gagal disimpan.');
        }
    }

    public function edit($id)
    {
        $data = ModelsUnit::findOrFail($id);

        $this->unitId = $id;
        $this->namaUnit = $data->nama_unit;
        $this->keterangan = $data->keterangan;

        $this->modalTitle = 'Edit Data';
        $this->dispatch('bukaModalEdit');
    }

    public function hapus()
    {
        $hapus = ModelsUnit::find($this->idYangAkanDihapus);

        if ($hapus) {
            $hapus->delete();
            session()->flash('success', 'Unit berhasil dihapus.');
        } else {
            session()->flash('error', 'Unit tidak ditemukan.');
        }

        // Reset agar tidak terhapus dua kali secara tak sengaja
        $this->reset('idYangAkanDihapus');

        // Emit JS untuk menutup modal
        $this->dispatch('tutupModalHapus');
    }

    public function resetCari()
    {
        $this->reset('cariUnit');
        $this->dispatch('resetCariFields');
    }

    public function bukaModal()
    {
        $this->dispatch('show-add-modal');
    }

    public function tutupModal()
    {
        $this->reset('namaUnit', 'keterangan', 'modalTitle');
        $this->dispatch('hide-modal');
    }

    public function resetFormInput()
    {
        $this->reset('namaUnit', 'keterangan', 'modalTitle');
        $this->dispatch('hide-modal');
    }
}
