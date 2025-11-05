<?php

namespace App\Livewire\Master;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Pegawai extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';

    public $cariUser = '';
    public $username, $unitId, $email, $name, $level, $enableUser;
    public $noHp, $alamat, $jabatan, $eselon;
    public $gender;
    public $active = false;
    public $cariUnit = '';
    public $dataUnit = [];
    public $defaultDataUnit = [];
    public $userId;
    public $idYangAkanDihapus;
    public $idYangAkanResetPassword;
    public $modalTitle = 'Tambah Data';
    public $tampilanRole = false;
    public $daftarRole;
    public $selectedRoles = [];

    protected function rules()
    {
        return [
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'username' => [
                'required',
                'string',
                'max:20',
                'regex:/^[A-Za-z0-9._-]+$/'
            ],
            'unitId' => 'required|numeric',
            'name' => 'required|string|max:255',
            'level' => 'required',
            'noHp' => 'nullable|max:13',
            'jabatan' => 'nullable|max:200',
            'eselon' => 'nullable|max:200',
            'gender' => 'required',
            'active' => 'required|boolean',
        ];
    }

    public function render()
    {
        $roleUser = User::query();
        $query = User::query();

        if ($this->cariUser) {
            $query->where('name', 'like', '%' . $this->cariUser . '%');
        }

        if ($this->userId) {
            $roleUser->with('roles')->findOrFail($this->userId);
        }

        $data = $query->orderBy('name', 'ASC')->paginate(10);

        return view('livewire.master.pegawai', compact('data', 'roleUser'));
    }

    public function updatingCariUnit()
    {
        $this->resetPage();
    }

    public function updatedCariUnit()
    {
        $this->dataUnit = Unit::where('nama_unit', 'like', '%' . $this->cariUnit . '%')
            ->orderBy('nama_unit', 'ASC')
            ->get();
    }

    public function mount()
    {
        $this->dataUnit = Unit::orderBy('nama_unit', 'ASC')->get();

        $this->defaultDataUnit = $this->dataUnit;
    }

    public function simpan()
    {
        $this->validate();

        if ($this->userId) {
            // update
            $user = User::find($this->userId);
            $user->update([
                'name' => $this->name,
                'unit_id' => $this->unitId,
                'email' => $this->email,
                'username' => $this->username,
                'level' => $this->level,
                'gender' => $this->gender,
                'is_active' => $this->active
            ]);
        } else {
            // create (password baru)
            $user = User::create([
                'name' => $this->name,
                'unit_id' => $this->unitId,
                'email' => $this->email,
                'username' => $this->username,
                'level' => $this->level,
                'password' => Hash::make($this->username),
                'gender' => $this->gender,
                'is_active' => $this->active
            ]);
        }

        // Simpan atau update data Pegawai yang terkait
        $user->pegawai()->updateOrCreate(
            ['user_id' => $user->id], // kondisi pencarian
            [
                'jabatan' => $this->jabatan,
                'eselon' => $this->eselon,
                'alamat' => $this->alamat,
                'no_hp' => $this->noHp,
                // tambahkan kolom lain sesuai tabel pegawai
            ]
        );

        if ($user) {
            session()->flash('success', 'Data berhasil disimpan.');
            $this->resetFormInput();
        } else {
            session()->flash('error', 'Data gagal disimpan.');
        }
    }

    public function edit($id)
    {
        $data = User::with('pegawai')->where('id', $id)->first();

        $this->userId = $id;
        $this->name = $data->name;
        $this->unitId = $data->unit_id;
        $this->email = $data->email;
        $this->username = $data->username;
        $this->level = $data->level;
        $this->noHp = $data->pegawai->no_hp;
        $this->alamat = $data->pegawai->alamat;
        $this->jabatan = $data->pegawai->jabatan;
        $this->eselon = $data->pegawai->eselon;
        $this->gender = $data->gender;
        $this->active = $data->is_active;

        $this->modalTitle = 'Edit Data';
        $this->dispatch('bukaModalEdit');
    }

    public function hapus()
    {
        $hapus = User::find($this->idYangAkanDihapus);

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

    public function resetPassword()
    {
        $user = User::find($this->idYangAkanResetPassword);

        if ($user) {
            $user->update([
                'password' => Hash::make($user->username)
            ]);
            session()->flash('success', 'Password berhasil direset.');
        } else {
            session()->flash('error', 'Data tidak ditemukan.');
        }

        // Reset agar tidak terreset dua kali secara tak sengaja
        $this->reset('idYangAkanResetPassword');

        // Emit JS untuk menutup modal
        $this->dispatch('hide-modal');
    }

    public function bukaTampilanRole($id)
    {
        $data = User::with('unit')->where('id', $id)->first();

        $this->userId = $id;
        $this->name = $data->name;
        $this->unitId = $data->unit_id;
        $this->email = $data->email;
        $this->username = $data->username;

        $this->tampilanRole = true;

        $this->daftarRole = Role::all();

        $user = User::with('roles')->find($this->userId);
        $this->selectedRoles = $user->roles->pluck('name')->toArray();
    }

    public function simpanRole()
    {
        $user = User::find($this->userId);
        $user->syncRoles($this->selectedRoles);

        session()->flash('message', 'Role berhasil diperbarui.');
    }

    public function tutupTampilanRole()
    {
        $this->tampilanRole = false;
        $this->resetFormInput();
    }

    public function resetCari()
    {
        $this->reset('cariUser');
        $this->dispatch('resetCariFields');
    }

    public function bukaModal()
    {
        $this->dispatch('show-add-modal');
    }

    public function tutupModal()
    {
        $this->reset('name', 'userId', 'unitId', 'email', 'username', 'level', 'noHp', 'jabatan', 'eselon', 'alamat', 'gender', 'active', 'cariUnit', 'modalTitle');
        $this->dataUnit = $this->defaultDataUnit;
        $this->dispatch('hide-modal');
    }

    public function resetFormInput()
    {
        $this->reset('name', 'userId', 'unitId', 'email', 'username', 'level', 'noHp', 'jabatan', 'eselon', 'alamat', 'gender', 'active', 'cariUnit', 'modalTitle');
        $this->dataUnit = $this->defaultDataUnit;
        $this->dispatch('hide-modal');
    }
}
