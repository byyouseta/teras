<div>

    <div class="d-flex mb-3 gap-2">
        <input type="text" class="form-control" placeholder="Cari nama / lokasi / terlapor..."
            wire:model.live.debounce.300ms="search" wire:keydown.enter="render">
        <select class="form-select w-auto" wire:model.live.debounce.300ms="statusFilter">
            <option value="">Semua status</option>
            <option value="open">Belum Selesai</option>
            <option value="resolved">Selesai</option>
        </select>

        <select class="form-select w-auto" wire:model.live.debounce.300ms="perPage">
            <option value="5">5 / halaman</option>
            <option value="10">10 / halaman</option>
            <option value="25">25 / halaman</option>
        </select>

        <button class="btn btn-outline-secondary ms-auto" wire:click="$refresh">Refresh</button>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-hover">
            <thead>
                <tr>
                    <th>Tiket No</th>
                    <th>Pelapor</th>
                    <th>Lokasi</th>
                    <th>Judul / Ringkasan</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reports as $i => $r)
                    <tr>
                        <td>{{ $r->ticket_no }}</td>
                        <td>
                            @if ($r->anonymous)
                                <span class="text-muted">Anonymous</span>
                            @else
                                {{ $r->nama }} <br><small class="text-muted">{{ $r->phone }}</small>
                            @endif
                        </td>
                        <td>{{ $r->lokasi ?? '-' }}</td>
                        <td style="max-width:320px;">
                            <strong>{{ Str::limit($r->terlapor_nama ?? '-', 50) }}</strong><br>
                            <small class="text-muted">{{ Str::limit($r->deskripsi, 120) }}</small>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($r->created_at)->locale('id')->translatedFormat('d-M-Y H:i') }}
                        </td>
                        <td>
                            @if ($r->resolved)
                                <span class="badge bg-success">Selesai</span><br>
                                <small
                                    class="text-muted">{{ \Carbon\Carbon::parse($r->resolved_at)->locale('id')->translatedFormat('d-M-Y') }}</small>
                            @else
                                <span class="badge bg-warning text-dark">Belum</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-info" title="Lihat"
                                    wire:click="viewReport({{ $r->id }})">
                                    <i class="ti ti-eye"></i>
                                </button>
                                {{-- <button class="btn btn-sm btn-success" title="Tandai Selesai"
                                    wire:click="markResolved({{ $r->id }})"
                                    @if ($r->resolved) disabled @endif>
                                    <i class="ti ti-check"></i>
                                </button> --}}
                                {{-- <button class="btn btn-sm btn-danger" title="Hapus"
                                    wire:click="deleteReport({{ $r->id }})">
                                    <i class="ti ti-trash"></i>
                                </button> --}}
                                @if ($r->file_pendukung)
                                    <a class="btn btn-sm btn-secondary" title="Download Lampiran"
                                        href="{{ route('etika.file.pendukung', ['file' => basename($r->file_pendukung)]) }}"
                                        target="_blank">
                                        <i class="ti ti-download"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada laporan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-2">
        {{ $reports->links() }}
    </div>

    {{-- Detail Modal --}}
    <div wire:ignore.self class="modal fade" id="reportModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    @if ($selectedReport)
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Pelapor:</strong>
                                    {{ $selectedReport->anonymous ? 'Anonymous' : $selectedReport->nama }}</p>
                                <p><strong>Kontak:</strong> {{ $selectedReport->phone ?? '-' }} /
                                    {{ $selectedReport->email ?? '-' }}</p>
                                <p><strong>Status:</strong>
                                    @if ($selectedReport->resolved)
                                        <span class="badge bg-success">Selesai</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Belum</span>
                                    @endif
                                </p>
                                <p><strong>Dibuat:</strong>
                                    {{ \Carbon\Carbon::parse($selectedReport->created_at)->locale('id')->translatedFormat('d F Y H:i') }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Lokasi:</strong> {{ $selectedReport->lokasi ?? '-' }}</p>
                                <p><strong>Waktu Kejadian:</strong>
                                    {{ $selectedReport->tanggal ? \Carbon\Carbon::parse($selectedReport->tanggal)->locale('id')->translatedFormat('d F Y') : '-' }}
                                    {{ $selectedReport->waktu ? \Carbon\Carbon::now()->locale('id')->translatedFormat('H:i') : '-' }}
                                </p>
                                <p><strong>Terlapor:</strong> {{ $selectedReport->terlapor_nama ?? '-' }}
                                    ({{ $selectedReport->terlapor_jabatan ?? '-' }})</p>
                            </div>
                        </div>

                        <hr>
                        <h6>Deskripsi</h6>
                        <p>{!! nl2br(e($selectedReport->deskripsi)) !!}</p>

                        @if ($selectedReport->file_pendukung && $previewUrl)
                            <hr>
                            <h6>Lampiran</h6>
                            <div style="height:500px;">
                                {{-- iframe preview --}}
                                <iframe src="{{ $previewUrl }}" style="width:100%; height:100%; border:0;"></iframe>
                            </div>
                        @endif
                    @endif
                    {{-- FORM TINDAK LANJUT --}}
                    @if ($selectedReport)
                        <hr>
                        <h6><strong>Form Tindak Lanjut (RTL)</strong></h6>

                        <form wire:submit.prevent="saveRTL">

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Status Laporan</label>
                                    <select class="form-select" wire:model="status_laporan">
                                        <option value="">-- Pilih --</option>
                                        <option value="diproses">Diproses</option>
                                        <option value="ditindaklanjuti">Ditindaklanjuti</option>
                                        <option value="selesai">Selesai</option>
                                    </select>
                                    @error('status_laporan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Ditindaklanjuti Oleh</label>
                                    <input type="text" class="form-control" wire:model="ditindak_lanjuti_oleh">
                                    @error('ditindak_lanjuti_oleh')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Tanggal Tindak Lanjut</label>
                                    <input type="date" class="form-control" wire:model.defer="tanggal_tindak_lanjut">
                                    @error('tanggal_tindak_lanjut')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-2">
                                    <label class="form-label">Tindak Lanjut</label>
                                    <textarea class="form-control" rows="3" wire:model="tindak_lanjut"></textarea>
                                    @error('tindak_lanjut')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-2">
                                    <label class="form-label">Catatan Tambahan</label>
                                    <textarea class="form-control" rows="3" wire:model="catatan"></textarea>
                                    @error('catatan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-2">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0">File Tindak Lanjut</h6>

                                        @if ($file_tindak_lanjut_preview)
                                            <button type="button" class="btn btn-danger btn-sm"
                                                title="Hapus File Tindak Lanjut" wire:click="deleteFileTindakLanjut"
                                                wire:loading.attr="disabled"
                                                onclick="return confirm('Hapus file tindak lanjut ini?')">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        @endif
                                    </div>

                                    {{-- FILE SUDAH DISIMPAN --}}
                                    @if ($file_tindak_lanjut_preview)
                                        @php
                                            $ext = pathinfo($file_tindak_lanjut_preview, PATHINFO_EXTENSION);
                                            $isImage = in_array(strtolower($ext), [
                                                'jpg',
                                                'jpeg',
                                                'png',
                                                'gif',
                                                'webp',
                                            ]);
                                        @endphp

                                        @if ($isImage)
                                            <img src="{{ $file_tindak_lanjut_preview }}"
                                                class="img-fluid border rounded"
                                                style="max-height:500px; display:block; margin:auto;">
                                        @else
                                            <iframe src="{{ $file_tindak_lanjut_preview }}"
                                                style="width:100%; height:500px; border:0;"></iframe>
                                        @endif
                                        @error('file_tindak_lanjut')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror

                                        {{-- BELUM ADA FILE --}}
                                    @else
                                        <label class="form-label">Unggah File Tindak Lanjut (Opsional)</label>
                                        <input type="file" class="form-control" wire:model="file_tindak_lanjut">

                                        <div wire:loading wire:target="file_tindak_lanjut"
                                            class="text-muted small mt-1">
                                            Mengunggah...
                                        </div>
                                        @error('file_tindak_lanjut')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror

                                        {{-- PREVIEW FILE BARU --}}
                                        @if ($file_tindak_lanjut)
                                            @php
                                                $isImage = in_array($file_tindak_lanjut->getClientOriginalExtension(), [
                                                    'jpg',
                                                    'jpeg',
                                                    'png',
                                                    'gif',
                                                    'webp',
                                                ]);
                                            @endphp

                                            @if ($isImage)
                                                <img src="{{ $file_tindak_lanjut->temporaryUrl() }}"
                                                    class="img-fluid border rounded mt-2"
                                                    style="max-height:500px; display:block; margin:auto;">
                                            @endif
                                        @endif
                                    @endif
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Diselesaikan Oleh</label>
                                    <input type="text" class="form-control" wire:model.defer="diselesaikan_oleh">
                                    @error('diselesaikan_oleh')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Tanggal Selesai</label>
                                    <input type="date" class="form-control" wire:model.defer="tanggal_selesai">
                                    @error('tanggal_selesai')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-3">
                                @if (session()->has('error'))
                                    <div class="alert alert-danger mt-3">
                                        {{ session('error') }}
                                    </div>
                                @elseif (session()->has('success'))
                                    <div class="alert alert-success mt-3">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if ($status_laporan != 'selesai')
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                            <span wire:loading.remove>Simpan RTL</span>
                                            <span wire:loading>Sedang menyimpan...</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </form>
                    @endif

                </div>
                <div class="modal-footer">
                    {{-- <button class="btn btn-danger" data-bs-dismiss="modal"
                        wire:click="deleteReport({{ $selectedReportId }})">Hapus</button> --}}

                    @if ($status_laporan == 'selesai' && !$selectedReport->resolved)
                        <button class="btn btn-success {{ $status_laporan == 'selesai' ? '' : 'disabled' }}"
                            wire:click="markResolved({{ $selectedReportId }})"><i class="ti ti-check"></i> Tandai
                            Selesai</button>
                    @endif

                    <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- JS listener --}}
    <script>
        window.addEventListener('open-report-modal', () => {
            var modal = new bootstrap.Modal(document.getElementById('reportModal'));
            modal.show();
        });

        window.addEventListener('notify', e => {
            // simple toast (ganti dengan sweetalert/toastr jika perlu)
            alert(e.detail?.message ?? 'Done');
        });
    </script>

</div>
