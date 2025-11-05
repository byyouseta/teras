<?php

namespace App\Livewire\Master;

use App\Models\Ruangan as ModelsRuangan;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Ruangan extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';

    public $cariRuangan = '';
    public $nama, $lokasi, $keterangan;
    public $ruanganId;
    public $idYangAkanDihapus;
    public $modalTitle = 'Tambah Data';

    protected function rules()
    {
        return [
            'nama' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255'
        ];
    }

    public function render()
    {
        $query = ModelsRuangan::query();

        if ($this->cariRuangan) {
            $query->where('nama', 'like', '%' . $this->cariRuangan . '%');
        }

        $data = $query->orderBy('nama', 'ASC')->paginate(10);

        // dd($data);

        return view('livewire.master.ruangan', compact('data'));
    }

    public function updatingCariRuangan()
    {
        $this->resetPage();
    }

    public function simpan()
    {
        $this->validate();

        // dd($this->unitId);

        $simpan = ModelsRuangan::updateOrCreate(
            ['id' => $this->ruanganId],
            [
                'nama' => $this->nama,
                'lokasi' => $this->lokasi,
                'keterangan' => $this->keterangan
            ]
        );

        if ($simpan) {
            session()->flash('success', 'Data berhasil disimpan.');
            $this->resetFormInput();
        } else {
            session()->flash('error', 'Data gagal disimpan.');
        }
    }

    public function edit($id)
    {
        $data = ModelsRuangan::findOrFail($id);

        $this->ruanganId = $id;
        $this->nama = $data->nama;
        $this->lokasi = $data->lokasi;
        $this->keterangan = $data->keterangan;

        $this->modalTitle = 'Edit Data';
        $this->dispatch('bukaModalEdit');
    }

    public function hapus()
    {
        $hapus = ModelsRuangan::find($this->idYangAkanDihapus);

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
        $this->reset('cariRuangan');
        $this->dispatch('resetCariFields');
    }

    public function bukaModal()
    {
        $this->dispatch('show-add-modal');
    }

    public function tutupModal()
    {
        $this->reset('nama', 'lokasi', 'keterangan', 'ruanganId', 'idYangAkanDihapus', 'modalTitle');
        $this->dispatch('hide-modal');
    }

    public function resetFormInput()
    {
        $this->reset('nama', 'lokasi', 'keterangan', 'ruanganId', 'idYangAkanDihapus', 'modalTitle');
        $this->dispatch('hide-modal');
    }
}
