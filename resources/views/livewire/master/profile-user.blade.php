<div>
    <form wire:submit.prevent="update">
        <div class="row">
            <div class="col-md-12 mx-auto">
                @if (session()->has('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="mb-3 text-center">
                    @if ($newPhoto)
                        <img src="{{ $newPhoto->temporaryUrl() }}" class="rounded-circle mb-2 border shadow-sm"
                            width="100" height="100" alt="Preview New Photo">
                        <div class="small text-info fst-italic">Preview foto baru</div>
                    @elseif ($photo)
                        <img src="{{ route('profile.image', $photo) }}" class="rounded-circle mb-2 shadow-sm"
                            width="100" height="100" alt="Current Profile Photo">
                        <div class="small text-muted">Foto saat ini</div>
                    @else
                        <img src="{{ $gender == 'male' ? asset('mantis/assets/images/user/avatar-2.jpg') : asset('mantis/assets/images/user/avatar-9.jpg') }}"
                            class="rounded-circle mb-2 shadow-sm" width="100" height="100" alt="Default Avatar">
                    @endif
                    <div class="mt-2">
                        <input type="file" wire:model="newPhoto" class="form-control w-auto mx-auto"
                            accept=".jpg,.jpeg,.png">
                        <small class="text-muted">Rekomendasi ukuran 100x100px, format: .jpg, .jpeg, .png</small>
                        @error('newPhoto')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div wire:loading wire:target="newPhoto" class="text-muted small mt-1">Uploading...</div>
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label class="form-label">NIP/Username</label>
                    <input type="text" wire:model="username" class="form-control">
                    @error('username')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" wire:model="name" class="form-control">
                    @error('name')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="modalnoHP" class="form-label">No Handphone</label>
                    <input type="text" class="form-control" id="modalnoHP" wire:model="noHp">
                    @error('noHp')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="modalAlamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="modalAlamat" cols="30" rows="5" wire:model='alamat'></textarea>
                    @error('alamat')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" wire:model="email" class="form-control">
                    @error('email')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="modalGender" class="form-label">Jenis Kelamin</label>
                    <div class="mt-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="inlineCheckbox1" value="male"
                                wire:model='gender'>
                            <label class="form-check-label" for="inlineCheckbox1">Laki-laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="inlineCheckbox2" value="female"
                                wire:model='gender'>
                            <label class="form-check-label" for="inlineCheckbox2">Perempuan</label>
                        </div>
                        @error('gender')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="modalJabatan" class="form-label">Jabatan</label>
                    <input type="text" class="form-control" id="modalJabatan" wire:model="jabatan">
                    @error('jabatan')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="modalEselon" class="form-label">Eselon (optional)</label>
                    <input type="text" class="form-control" id="modalEselon" wire:model="eselon">
                    @error('eselon')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="modalUnit" class="form-label">Unit</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="modalUnit"
                            wire:model.live.debounce.300ms='cariUnit' placeholder="Cari Unit">
                        <select class="form-control" wire:model='unitId'>
                            <option value="">Pilih</option>
                            @foreach ($dataUnit as $u)
                                <option value="{{ $u->id }}">{{ $u->nama_unit }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('unitId')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-md-12 mt-2">
                <div>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-save"></i> Save Changes
                    </button>

                    @if (session()->has('success'))
                        <label for="success" class="fst-italic ms-5 text-success">{{ session('success') }}</label>
                    @endif
                    @if (session()->has('error'))
                        <label for="error"
                            class="text-danger fst-italic ms-5 text-danger">{{ session('error') }}</label>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>
