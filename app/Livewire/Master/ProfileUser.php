<?php

namespace App\Livewire\Master;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileUser extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $password;
    public $photo;
    public $gender;
    public $username, $unitId;
    public $noHp, $alamat, $jabatan, $eselon;
    public $active = false;
    public $cariUnit = '';
    public $dataUnit = [];
    public $defaultDataUnit = [];

    public $newPhoto; // file baru

    public function mount()
    {
        $user = User::find(Auth::id());

        $this->name = $user->name;
        $this->email = $user->email;
        $this->photo = $user->foto; // asumsikan ada kolom photo di tabel users
        $this->gender = $user->gender; // asumsikan ada kolom gender di tabel users
        $this->username = $user->username;
        $this->unitId = $user->unit_id;
        $this->noHp = $user->pegawai->no_hp;
        $this->alamat = $user->pegawai->alamat;
        $this->jabatan = $user->pegawai->jabatan;
        $this->eselon = $user->pegawai->eselon;

        $this->dataUnit = Unit::orderBy('nama_unit', 'ASC')->get();

        $this->defaultDataUnit = $this->dataUnit;
    }

    public function updatedCariUnit()
    {
        $this->dataUnit = Unit::where('nama_unit', 'like', '%' . $this->cariUnit . '%')
            ->orderBy('nama_unit', 'ASC')
            ->get();
    }

    public function update()
    {
        $user = Auth::user();

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:6',
            'newPhoto' => 'nullable|image|max:500', // max 500KB
            'username' => [
                'required',
                'string',
                'max:20',
                'regex:/^[A-Za-z0-9._-]+$/'
            ],
            'unitId' => 'required|numeric',
            'noHp' => 'required|max:13',
            'jabatan' => 'nullable|max:200',
            'eselon' => 'nullable|max:200',
            'gender' => 'required',
        ]);

        if ($this->newPhoto) {
            // Simpan foto baru
            $path = $this->newPhoto->store('profile', 'public');
            $filename = basename($path);

            // Hapus foto lama jika ada
            if ($user->foto && Storage::disk('public')->exists('profile/' . $user->foto)) {
                Storage::delete('public/profile/' . $user->foto);
            }

            $user->foto = $filename;
        }

        $user->name = $this->name;
        $user->email = $this->email;
        $user->unit_id = $this->unitId;
        $user->username = $this->username;
        $user->gender = $this->gender;

        if (!empty($this->password)) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        $user->pegawai()->update(
            ['user_id' => $user->id], // kondisi pencarian
            [
                'jabatan' => $this->jabatan,
                'eselon' => $this->eselon,
                'alamat' => $this->alamat,
                'no_hp' => $this->noHp,
                // tambahkan kolom lain sesuai tabel pegawai
            ]
        );

        session()->flash('success', 'Profile updated successfully!');
    }

    public function render()
    {
        return view('livewire.master.profile-user');
    }
}
