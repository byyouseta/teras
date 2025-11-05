<?php

namespace App\Livewire\Master;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserRoleEditor extends Component
{
    public $userId;
    public $roles;
    public $selectedRoles = [];

    #[On('edit-user-roles')]
    public function loadUserRoles($data)
    {
        dd($data);
        $this->userId = $data['id'];
        $user = User::with('roles')->find($this->userId);

        $this->roles = Role::all();
        $this->selectedRoles = $user->roles->pluck('name')->toArray();
    }

    public function save()
    {
        $user = User::find($this->userId);
        $user->syncRoles($this->selectedRoles);

        session()->flash('message', 'Role berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.master.user-role-editor');
    }
}
