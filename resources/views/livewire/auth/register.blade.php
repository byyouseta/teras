<div>
    <div class="card my-5">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <h3 class="mb-0"><b>Sign up</b></h3>
                <a href="{{ route('login') }}" class="link-primary">Already have an account?</a>
            </div>
            <form wire:submit.prevent='register'>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">First Name*</label>
                            <input type="text" class="form-control" placeholder="First Name" wire:model='firstname'>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" placeholder="Last Name" wire:model='lastname'>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">NIP</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                        placeholder="Nomor Induk Pegawai" wire:model="username">
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Email Address*</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                        placeholder="Email Address" wire:model="email">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <input type="{{ $showPassword ? 'text' : 'password' }}"
                            class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                            wire:model="password">
                        <button type="button" class="btn btn-outline-secondary" wire:click="$toggle('showPassword')">
                            @if ($showPassword)
                                <i class="ti ti-eye-off"></i>
                            @else
                                <i class="ti ti-eye"></i>
                            @endif
                        </button>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="{{ $showPassword ? 'text' : 'password' }}"
                        class="form-control @error('password_confirmation') is-invalid @enderror"
                        placeholder="Confirm Password" wire:model="password_confirmation">
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <p class="mt-4 text-sm text-muted">By Signing up, you agree to our <a href="#"
                        class="text-primary">
                        Terms of Service </a> and <a href="#" class="text-primary"> Privacy Policy</a></p>
                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-primary">Create Account</button>
                </div>
            </form>

            <div class="saprator mt-3">
                <span>Menu</span>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="d-grid">
                        <a href="/" type="button" class="btn mt-2 btn-light-primary bg-light text-muted">
                            <img src="{{ asset('assets/images/home-button.png') }}" alt="img" style="width: 16px;">
                            <span class="d-none d-sm-inline-block"> Home</span>
                        </a>
                    </div>
                </div>
                <div class="col-4">
                    <div class="d-grid">
                        <button type="button" class="btn mt-2 btn-light-primary bg-light text-muted">
                            <img src="{{ asset('assets/images/lock.png') }}" alt="img" style="width: 16px;"><span
                                class="d-none d-sm-inline-block"> Forgot Password</span>
                        </button>
                    </div>
                </div>
                <div class="col-4">
                    <div class="d-grid">
                        <a type="button" class="btn mt-2 btn-light-primary bg-light text-muted"
                            href="{{ route('login') }}">
                            <img src="{{ asset('assets/images/user.png') }}" alt="img" style="width: 16px;">
                            <span class="d-none d-sm-inline-block"> Login</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
