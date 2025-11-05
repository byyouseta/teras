<?php

namespace App\Livewire\Akses;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class Roles extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';

    public $cariRole = '';
    public $cariPermission = '';
    public $cariPermissionRoles = '';
    public $nama;
    public $roleId;
    // public $rolePermission;
    public $selectedPermission;
    public $selectedPermissions = [];
    public $daftarPermission;
    public $idYangAkanDihapus;
    public $modalTitle = 'Tambah Data';

    protected $rules = [
        'nama' => 'required|min:3|unique:roles,name'
    ];

    public function mount() {}

    public function updatingCariPermission()
    {
        $this->resetPage();
    }

    public function updatingCariPermissionRoles()
    {
        $this->resetPage();
    }

    public function updatedCariPermission()
    {
        $this->daftarPermission = Permission::where('name', 'like', '%' . $this->cariPermission . '%')
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function simpan()
    {
        //Autorize multiakses
        if (! Gate::any(['Akses-Roles-Update', 'Akses-Roles-Create'])) {
            abort(403);
        }

        $this->validate();

        $simpan = Role::updateOrCreate(
            ['id' => $this->roleId],
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
        $this->authorize('Akses-Roles-Update');

        $data = Role::findOrFail($id);

        $this->roleId = $id;
        $this->nama = $data->name;

        $this->modalTitle = 'Edit Data';
        $this->dispatch('bukaModalEdit');
    }

    public function listPermission($id)
    {
        $data = Role::findOrFail($id);

        $this->roleId = $id;
        $this->nama = $data->name;

        $this->daftarPermission = Permission::orderBy('name', 'ASC')->get();
    }

    public function simpanRolePermission()
    {
        $this->authorize('Akses-Roles-Create');

        $role = Role::findOrFail($this->roleId);
        $role->givePermissionTo(Permission::find($this->selectedPermission));
    }

    public function removeSelected()
    {
        $this->authorize('Akses-Roles-Delete');

        $role = Role::findOrFail($this->roleId);

        if (!empty($this->selectedPermissions)) {
            $role->permissions()->detach($this->selectedPermissions);

            try {
                // 🔄 Reset cache permission agar perubahan langsung berlaku
                app()[PermissionRegistrar::class]->forgetCachedPermissions();
            } catch (\Exception $e) {
                // 🧾 Catat error ke activity log
                // activity()
                //     ->causedBy(auth()->user())
                //     ->performedOn($role)
                //     ->event('cache-reset-failed')
                //     ->withProperties([
                //         'role' => $role->name,
                //         'message' => $e->getMessage(),
                //     ])
                //     ->log('Gagal melakukan reset cache permission Spatie');
                Log::warning('Gagal reset cache permission: ' . $e->getMessage());
            }

            $this->dispatch('notify', 'Permission berhasil dihapus dari role.');
            $this->selectedPermissions = [];
        }
    }

    public function hapus()
    {
        $this->authorize('Akses-Roles-Delete');

        $hapus = Role::find($this->idYangAkanDihapus);

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
        $this->reset('cariRole');
        $this->dispatch('resetCariFields');
    }

    public function bukaModal()
    {
        $this->dispatch('show-add-modal');
    }

    public function tutupModal()
    {
        $this->reset('nama', 'roleId', 'idYangAkanDihapus', 'cariPermission', 'daftarPermission', 'modalTitle');
        $this->dispatch('hide-modal');
    }

    public function resetFormInput()
    {
        $this->reset('nama', 'roleId', 'idYangAkanDihapus', 'cariPermission', 'modalTitle');
        $this->dispatch('hide-modal');
    }

    public function render()
    {
        $this->authorize('Akses-Roles-List');

        if (!empty($this->roleId)) {
            $role = Role::findOrFail($this->roleId);
            $rolePermission = $role->permissions()
                ->when($this->cariPermissionRoles, function ($query) {
                    $query->where('name', 'like', '%' . $this->cariPermissionRoles . '%');
                })
                ->paginate(10);
        } else {
            $rolePermission = null;
        }

        $data = Role::orderBy('name', 'ASC')->paginate(10);
        return view('livewire.akses.roles', compact('data', 'rolePermission'));
    }
}
