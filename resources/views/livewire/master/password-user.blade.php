<div>
    <form wire:submit.prevent="updatePassword">
        {{-- Password Lama --}}
        <div class="mb-3">
            <label for="current_password" class="form-label">Password Lama</label>
            <div class="input-group">
                <input type="{{ $showCurrent ? 'text' : 'password' }}" id="current_password"
                    wire:model.defer="current_password"
                    class="form-control @error('current_password') is-invalid @enderror">
                <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="toggle('showCurrent')">
                    <i class="ti {{ $showCurrent ? 'ti-eye-off' : 'ti-eye' }}"></i>
                </button>
                @error('current_password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Password Baru --}}
        <div class="mb-3">
            <label for="new_password" class="form-label">Password Baru</label>
            <div class="input-group">
                <input type="{{ $showNew ? 'text' : 'password' }}" id="new_password" wire:model.defer="new_password"
                    class="form-control @error('new_password') is-invalid @enderror">
                <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="toggle('showNew')">
                    <i class="ti {{ $showNew ? 'ti-eye-off' : 'ti-eye' }}"></i>
                </button>
                @error('new_password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Konfirmasi Password --}}
        <div class="mb-3">
            <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
            <div class="input-group">
                <input type="{{ $showConfirm ? 'text' : 'password' }}" id="new_password_confirmation"
                    wire:model.defer="new_password_confirmation" class="form-control">
                <button type="button" class="btn btn-outline-secondary btn-sm" wire:click="toggle('showConfirm')">
                    <i class="ti {{ $showConfirm ? 'ti-eye-off' : 'ti-eye' }}"></i>
                </button>
            </div>
        </div>
        {{-- Tombol Simpan --}}
        <div class="d-flex justify-content-between align-items-center">
            <button type="submit" class="btn btn-primary btn-sm" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="updatePassword">Simpan Password</span>
                <span wire:loading wire:target="updatePassword">
                    <i class="spinner-border spinner-border-sm"></i> Menyimpan...
                </span>
            </button>

            @if (session()->has('success'))
                <span class="text-success small">{{ session('success') }}</span>
            @endif
        </div>
    </form>
</div>
