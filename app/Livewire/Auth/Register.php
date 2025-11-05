<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    public $firstname = '';
    public $lastname = '';
    public $username = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $showPassword = false;

    public function register()
    {
        $this->validate([
            'firstname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $cekUserSimadam = DB::connection('mysqlsimadam')->table('users')
            ->select('users.*')
            ->where('users.userid', $this->username)
            ->first();

        if (!$cekUserSimadam) {
            // Tambahkan error ke field username
            $this->addError('username', 'User ini belum terdaftar di SIMADAM.');
            return;
        }

        dd('stop');

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        Auth::login($user); // langsung login setelah register
        session()->regenerate();

        return redirect()->intended('/main'); // arahkan ke halaman utama
    }

    public function render()
    {
        return view('livewire.auth.register')
            ->layout('layouts.mantis_auth');
    }
}
