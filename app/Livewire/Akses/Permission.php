<?php

namespace App\Livewire\Akses;

use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';

    public $cariPermission = '';
    public $nama;
    public $permissionId;
    public $idYangAkanDihapus;
    public $modalTitle = 'Tambah Data';

    protected $rules = [
        'nama' => 'required|string|unique:permissions,name'
    ];

    public function updatingCariPermission()
    {
        $this->resetPage();
    }

    public function simpan()
    {
        $this->authorize('Akses-Permission-Create');

        $this->validate();

        // dd($this->unitId);

        $simpan = ModelsPermission::updateOrCreate(
            ['id' => $this->permissionId],
            ['name' => $this->nama]
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
        $this->authorize('Akses-Permission-Update');

        $data = ModelsPermission::findOrFail($id);

        $this->permissionId = $id;
        $this->nama = $data->name;

        $this->modalTitle = 'Edit Data';
        $this->dispatch('bukaModalEdit');
    }

    public function hapus()
    {
        $this->authorize('Akses-Permission-Delete');

        $hapus = ModelsPermission::find($this->idYangAkanDihapus);

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
        $this->reset('cariPermission');
        $this->dispatch('resetCariFields');
    }

    public function bukaModal()
    {
        $this->dispatch('show-add-modal');
    }

    public function tutupModal()
    {
        $this->reset('nama', 'permissionId', 'idYangAkanDihapus', 'modalTitle');
        $this->dispatch('hide-modal');
    }

    public function resetFormInput()
    {
        $this->reset('nama', 'permissionId', 'idYangAkanDihapus', 'modalTitle');
        $this->dispatch('hide-modal');
    }

    public function render()
    {
        $query = ModelsPermission::query();

        if ($this->cariPermission) {
            $query->where('name', 'like', '%' . $this->cariPermission . '%');
        }

        $data = $query->orderBy('name', 'ASC')->paginate(10);

        return view('livewire.akses.permission', compact('data'));
    }
}
