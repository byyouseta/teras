<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Livewire\Component;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;
    public $showPassword = false;
    public $recaptcha;

    public function login()
    {
        $messages = [
            // 'email.email' => 'Kolom email harus dalam format email',
            'recaptcha.recaptchav3' => 'Login blocked, suspicious activity detected.',
        ];

        // dd($this->recaptcha);

        $this->validate([
            'email' => 'required',
            'password' => 'required',
            'recaptcha' => 'required|recaptchav3:login,0.5',
        ], $messages);

        $this->checkRateLimit();

        // cek apakah input berupa email atau nip
        $field = filter_var($this->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = \App\Models\User::where($field, $this->email)->first();

        if ($user && !$user->is_active) {
            activity()
                ->causedBy(Auth::user())
                ->withProperties(['ip' => request()->ip(), 'action' => 'Login Failed - Inactive Account - ' . $this->email])
                ->log('User gagal login');

            throw ValidationException::withMessages([
                'email' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
            ]);
        }

        if (Auth::attempt([$field => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::clear($this->throttleKey()); // reset counter kalau sukses login
            session()->regenerate();

            activity()
                ->causedBy(Auth::user())
                ->withProperties(['ip' => request()->ip(), 'action' => 'Login Success'])
                ->log('User berhasil login');

            return redirect()->intended('/main');
        }

        activity()
            ->causedBy(Auth::user())
            ->withProperties(['ip' => request()->ip(), 'action' => 'Login Failed - Wrong Credentials - ' . $this->email])
            ->log('User gagal login');

        RateLimiter::hit($this->throttleKey(), 60); // gagal, tambahkan 1 attempt (expired 60 detik)
        throw ValidationException::withMessages([
            'email' => __('The provided credentials do not match our records.'),
        ]);
    }

    protected function checkRateLimit()
    {
        if (RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            $seconds = RateLimiter::availableIn($this->throttleKey());

            activity()
                ->causedBy(Auth::user())
                ->withProperties(['ip' => request()->ip(), 'action' => 'Login Failed - Too Many Attempts'])
                ->log('User melakukan terlalu banyak percobaan login gagal');

            throw ValidationException::withMessages([
                'email' => __('Too many login attempts. Please try again in :seconds seconds.', [
                    'seconds' => $seconds,
                ]),
            ]);
        }
    }

    protected function throttleKey()
    {
        return Str::lower($this->email) . '|' . request()->ip();
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.mantis_auth');
    }
}
