<div>
    <div class="card my-5">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <h3 class="mb-0"><b>Login</b></h3>
                <a href="#" class="link-primary">Don't have an account?</a>
            </div>
            <form wire:submit.prevent="login" id="login-form">
                <div class="form-group mb-3">
                    <label class="form-label">NIP / Email Address</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                        placeholder="NIP / Email Address" wire:model="email">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <input type="{{ $showPassword ? 'text' : 'password' }}"
                            class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                            wire:model="password" autocomplete="on">
                        <button type="button" class="btn btn-outline-secondary" wire:click="$toggle('showPassword')">
                            @if ($showPassword)
                                <i class="ti ti-eye-off"></i>
                            @else
                                <i class="ti ti-eye"></i>
                            @endif
                        </button>
                    </div>

                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>
                <div class="d-flex mt-1 justify-content-between">
                    <div class="form-check">
                        <input class="form-check-input input-primary" type="checkbox" id="customCheckc1"
                            wire:model="remember">
                        <label class="form-check-label text-muted" for="customCheckc1">Keep me sign in</label>
                    </div>
                    {{-- <h5 class="text-secondary f-w-400">Forgot Password?</h5> --}}
                </div>
                <div class="d-grid mt-4">
                    <!-- reCAPTCHA -->
                    <input type="hidden" id="g-recaptcha-response" wire:model="recaptcha" name="recaptcha">
                    @error('recaptcha')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                    <button type="submit" id="login-btn" class="btn btn-primary">Login
                        <div class="spinner-grow  spinner-grow-sm float-end" role="status" wire:loading>
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </button>
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
                        <a type="button" class="btn mt-2 btn-light-primary bg-light text-muted" href="#">
                            <img src="{{ asset('assets/images/add-user.png') }}" alt="img" style="width: 16px;">
                            <span class="d-none d-sm-inline-block"> Register</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @script
        <script>
            document.getElementById('login-form').addEventListener('submit', function(e) {
                e.preventDefault(); // Mencegah form disubmit secara default

                grecaptcha.ready(function() {
                    grecaptcha.execute('{{ config('recaptchav3.sitekey') }}', {
                        action: 'login'
                    }).then(function(token) {
                        // Set token reCAPTCHA di properti Livewire sebelum submit
                        @this.set('recaptcha', token);

                        // Panggil metode login di Livewire setelah token diatur
                        @this.call('login');
                    });
                });
            });
        </script>
    @endscript
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('recaptchav3.sitekey') }}"></script>



</div>
