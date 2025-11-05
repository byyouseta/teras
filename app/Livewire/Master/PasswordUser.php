<?php

namespace App\Livewire\Master;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class PasswordUser extends Component
{
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    // State untuk show/hide password
    public $showCurrent = false;
    public $showNew = false;
    public $showConfirm = false;

    protected function rules()
    {
        return [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ];
    }

    public function toggle($field)
    {
        // Membalik nilai boolean sesuai field
        $this->{$field} = !$this->{$field};
    }

    public function updatePassword()
    {
        $this->validate();

        $user = Auth::user();

        // Pastikan password lama benar
        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Password lama tidak sesuai.');
            return;
        }

        // Update password baru
        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        // Reset form
        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

        session()->flash('success', 'Password berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.master.password-user');
    }
}
