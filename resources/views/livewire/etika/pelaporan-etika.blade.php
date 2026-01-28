<div>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Pelaporan Dugaan Pelanggaran Etik</h4>
            <p class="text-muted">KAMI AKAN MENJAMIN KERAHASIAAN DATA ANDA</p>

            <form wire:submit.prevent="submit">

                <div class="mb-3">
                    <label class="form-label">Apakah anda ingin merahasiakan identitas diri (anonymous)?</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="anonYes"
                                wire:model.live.debounce.300="anonymous" value="1">
                            <label class="form-check-label" for="anonYes">Ya</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="anonNo"
                                wire:model.live.debounce.300="anonymous" value="0">
                            <label class="form-check-label" for="anonNo">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Status (pelapor)</label>
                        <select class="form-select" wire:model="status">
                            <option value="">-- Pilih Status --</option>
                            <option value="Korban">Korban</option>
                            <option value="Saksi">Saksi</option>
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nama Pelapor<small>* Optional</small></label>
                        <input type="text" class="form-control" wire:model.defer="nama"
                            {{ $anonymous == true ? 'disabled' : '' }}>
                        @error('nama')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label class="form-label">No HP / WhatsApp Pelapor<small>* Optional</small></label>
                        <input type="text" class="form-control" wire:model.defer="phone">
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email Pelapor<small>* Optional</small></label>
                        <input type="email" class="form-control" wire:model.defer="email">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <small class="text-muted fst-italic">* Dengan memberikan No HP dan email yang benar, Anda dapat
                            mengetahui
                            perkembangan status penanganan pengaduan dan membantu proses investigasi menjadi lebih
                            cepat.</small>
                    </div>
                </div>

                <hr>
                <h5>Kejadian yang akan dilaporkan</h5>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label class="form-label">Lokasi Kejadian</label>
                        <input type="text" class="form-control" wire:model.defer="lokasi">
                        @error('lokasi')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Hari/Tanggal</label>
                        <input type="date" class="form-control" wire:model.defer="tanggal">
                        @error('tanggal')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Waktu</label>
                        <input type="time" class="form-control" wire:model.defer="waktu">
                        @error('waktu')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <hr>
                <h5>Identitas Terlapor</h5>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label class="form-label">Nama Terlapor</label>
                        <input type="text" class="form-control" wire:model.defer="terlapor_nama">
                        @error('terlapor_nama')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jabatan Terlapor</label>
                        <input type="text" class="form-control" wire:model.defer="terlapor_jabatan">
                        @error('terlapor_jabatan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label">Silakan laporkan kejadian yang dialami dengan rinci</label>
                    <textarea class="form-control" rows="5" wire:model.defer="deskripsi"></textarea>
                    @error('deskripsi')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mt-3">
                    <label class="form-label">Jika ada dokumen bukti atau pendukung, mohon upload</label>
                    <input type="file" class="form-control" wire:model="file">
                    @error('file')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <div wire:loading wire:target="file">Uploading...</div>
                </div>

                <div class="mt-3 form-check">
                    <input class="form-check-input" type="checkbox" id="agree" wire:model="agree">
                    <label class="form-check-label" for="agree">Demikian formulir pelaporan ini saya buat tanpa
                        paksaan dari pihak manapun</label>
                    @error('agree')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mt-3">
                    <label class="form-label">Captcha: {{ $captchaQuestion }}</label>
                    <input type="text" class="form-control" wire:model.defer="captchaUser">
                    @error('captchaUser')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mt-4 d-flex justify-content-end">
                    <button class="btn btn-secondary me-2" type="button"
                        wire:click.prevent="resetForm">Reset</button>
                    <button class="btn btn-primary" type="submit" wire:loading.attr="disabled">
                        <span wire:loading.remove> Simpan</span>
                        <span wire:loading><span class="spinner-border spinner-border-sm me-2" role="status"></span>
                            Menyimpan...</span>
                    </button>
                </div>
            </form>
            @if (session()->has('message'))
                <div class="alert alert-success mt-3">
                    {{ session('message') }}
                </div>
            @elseif (session()->has('error'))
                <div class="alert alert-danger mt-3">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>
</div>
