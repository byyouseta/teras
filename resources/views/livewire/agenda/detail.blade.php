<div>
    <style>
        .carousel-control-prev-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 16 16' fill='black' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 1 L5 8 L11 15'/%3E%3C/svg%3E");
        }

        .carousel-control-next-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 16 16' fill='black' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5 1 L11 8 L5 15'/%3E%3C/svg%3E");
        }
    </style>

    <div class="card">
        <div class="card-header">
            <div class="float-start">
                <form class="row g-3">
                    <div class="col-auto">
                        <a href="{{ route('agenda.list') }}" class="btn btn-primary btn-sm">Kembali</a>
                    </div>
                    @if ($agenda->status == 'Pengajuan' || $agenda->status == 'Ditolak')
                        <div class="col-auto">
                            <button type="button" class="btn btn-info btn-sm"
                                wire:click="verifikasiModal">Verifikasi</button>
                        </div>
                    @endif
                    @if ($agenda->status == 'Dijadwalkan')
                        <div class="col-auto">
                            <button type="button" class="btn btn-secondary btn-sm" data-toggle="tooltip"
                                data-placement="bottom" title="Set Selesai" data-bs-toggle="modal"
                                data-bs-target="#modalKonfirmasiSelesai">Selesai</button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless table-sm">
                    <tr>
                        <th style="width: 15%;">Nama Rapat</th>
                        <td style="width: 35%;">{{ $agenda->nama_agenda }}</td>
                        <th style="width: 15%;">PIC Rapat</th>
                        <td style="width: 35%;">{{ $agenda->userpic->name }}</td>
                    </tr>
                    <tr>
                        <th style="width: 15%;">Tanggal</th>
                        <td style="width: 35%;">
                            {{ \Carbon\Carbon::parse($agenda->tanggal)->locale('id')->translatedFormat('d M Y') }}</td>
                        <th style="width: 15%;">Pengundang Acara</th>
                        <td style="width: 35%;">{{ $agenda->pengundang }}</td>
                    </tr>
                    <tr>
                        <th style="width: 15%;">Waktu</th>
                        <td style="width: 35%;">{{ \Carbon\Carbon::parse($agenda->waktu_mulai)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($agenda->waktu_selesai)->format('H:i') }}</td>
                        <th style="width: 15%;">Peserta / Presensi</th>
                        <td style="width: 35%;">{{ $agenda->user->count() }} /
                            {{ $agenda->user->where('pivot.presensi', 'sudah')->count() }}</td>
                    </tr>
                    <tr>
                        <th style="width: 15%;">Tempat</th>
                        <td style="width: 35%;">{{ $agenda->ruangan->nama }}</td>
                        <th style="width: 15%;">Notulen</th>
                        <td style="width: 35%;">
                            @if (!empty($agenda->notulen))
                                <span class="badge rounded-pill text-bg-info btn btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#previewModalNotulen"
                                    style="height: 18px; font-size:11px;">Preview</span>
                                <span class="badge rounded-pill text-bg-danger btn btn-sm"
                                    wire:click="hapusBerkas('notulen')"
                                    style="height: 18px; font-size:11px;">Hapus</span>
                            @else
                                <span class="badge rounded-pill text-bg-warning btn"
                                    wire:click="uploadNotulenModal('notulen')"
                                    style="height: 18px; font-size:11px;">belum
                                    ada Notulen</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 15%;">Keterangan</th>
                        <td style="width: 35%;">{{ $agenda->keterangan }}</td>
                        <th style="width: 15%;">Daftar Hadir</th>
                        <td style="width: 35%;">
                            @if (!empty($agenda->daftar))
                                <span class="badge rounded-pill text-bg-success btn btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#previewModalDaftar" style="height: 18px; font-size:11px;">Daftar
                                    Hadir Luring</span>
                                <span class="badge rounded-pill text-bg-danger btn btn-sm"
                                    wire:click="hapusBerkas('daftarHadir')"
                                    style="height: 18px; font-size:11px;">Hapus</span>
                            @else
                                <span class="badge rounded-pill text-bg-warning btn"
                                    wire:click="uploadNotulenModal('daftarHadir')"
                                    style="height: 18px; font-size:11px;">belum
                                    ada Daftar Hadir Luring</span>
                            @endif
                            {{-- <a href="{{ route('agenda.hadir', ['id' => Crypt::encrypt($agenda->id)]) }}"
                                target="_blank"><span class="badge rounded-pill text-bg-primary">Daring</span></a> --}}
                            <span class="badge rounded-pill text-bg-primary btn"
                                wire:click="daftarhadir({{ $agenda->id }})" wire:loading.attr="disabled"
                                style="height: 18px; font-size:11px; padding-top: 2px; padding-bottom: 2px;">
                                <span wire:loading.remove wire:target="daftarhadir">
                                    Daftar Hadir Luring PDF
                                </span>
                                <span wire:loading wire:target="daftarhadir">
                                    <i class="spinner-border spinner-border-sm"></i> Menggenerate...
                                </span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 15%;">Status</th>
                        <td style="width: 35%;">
                            @if ($agenda->status == 'Pengajuan')
                                <span class="badge rounded-pill text-bg-warning">
                                @elseif($agenda->status == 'Dijadwalkan')
                                    <span class="badge rounded-pill text-bg-success">
                                    @elseif($agenda->status == 'Selesai')
                                        <span class="badge rounded-pill text-bg-primary">
                            @endif
                            {{ $agenda->status }}</span>
                        </td>
                        <th style="width: 15%;">Materi</th>
                        <td style="width: 35%;">
                            @if (!empty($agenda->materi))
                                <span class="badge rounded-pill text-bg-success btn btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#previewModalMateri" style="height: 18px; font-size:11px;">Lihat
                                    Materi</span>
                                <span class="badge rounded-pill text-bg-danger btn btn-sm"
                                    wire:click="hapusBerkas('materi')"
                                    style="height: 18px; font-size:11px;">Hapus</span>
                            @else
                                <span class="badge rounded-pill text-bg-warning btn"
                                    wire:click="uploadNotulenModal('materi')"
                                    style="height: 18px; font-size:11px;">belum ada materi</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 15%;">Varifikator</th>
                        <td style="width: 35%;">{{ $agenda->verifikator }}</td>
                        <th style="width: 15%;">Dokumentasi</th>
                        <td style="width: 35%;">
                            <span class="badge rounded-pill text-bg-warning btn"
                                wire:click="uploadNotulenModal('dokumentasi')" style="height: 18px; font-size:11px;"><i
                                    class="ti ti-upload" style="height: 18px; font-size:11px;"></i> Unggah</span>
                            @if ($agenda->gambar && count($agenda->gambar) > 0)
                                <span class="badge rounded-pill text-bg-info btn btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#carouselModal" style="height: 18px; font-size:11px;">Lihat
                                    Dokumentasi</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 15%;">Catatan</th>
                        <td style="width: 35%;">{{ $agenda->catatan }}</td>
                        <th style="width: 15%;">Undangan</th>
                        <td style="width: 35%;">
                            {{-- Backup tombol samping --}}
                            {{-- <a href="{{ route('agenda.undangan', Crypt::encrypt($agenda->id)) }}"
                                target="_blank"><span class="badge rounded-pill text-bg-primary btn"
                                    style="height: 18px; font-size:11px;">Undangan</span></a> --}}
                            <span class="badge rounded-pill text-bg-primary btn"
                                wire:click="undangan({{ $agenda->id }})" wire:loading.attr="disabled"
                                style="height: 18px; font-size:11px; padding-top: 2px; padding-bottom: 2px;">
                                <span wire:loading.remove wire:target="undangan">
                                    Lihat PDF Undangan
                                </span>
                                <span wire:loading wire:target="undangan">
                                    <i class="spinner-border spinner-border-sm"></i> Menggenerate...
                                </span>
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title">
                Peserta Undangan
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-9">
                    <form wire:submit.prevent='{{ $editNamaUndangan ? 'updateUndangan' : 'tambahUndangan' }}'>
                        <div class="mb-3">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control form-control-sm w-25"
                                    wire:model.live.debounce.300ms="cariUser" placeholder="Ketik untuk mencari...">
                                <select id="modalPengundang" class="form-control form-control-sm w-50"
                                    wire:model='namaUndangan'>
                                    <option value="">Pilih</option>
                                    @foreach ($dataUser as $u)
                                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                                    @endforeach
                                </select>
                                <input type="number" class="form-control form-control-sm w-20"
                                    placeholder="Urutan Undangan" min="1" step="1" wire:model='urutan'>
                                <button class="btn btn-sm btn-primary"
                                    type="submit">{{ $editNamaUndangan ? 'Update' : 'Tambah' }}</button>
                                @if ($editNamaUndangan)
                                    <button class="btn btn-sm btn-secondary ms-2" wire:click='batalEdit'
                                        type="button">Batal</button>
                                @endif
                            </div>
                            @error('namaUndangan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="col-3">
                    <div class="float-end">
                        <div class="row g-3">
                            <div class="col-auto">
                                <input type="text" class="form-control form-control-sm"
                                    placeholder="Cari Nama Undangan"
                                    wire:model.live.debounce.300ms="cariNamaUndangan" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <hr>
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover table-sm" id="example">
                            <thead class="align-middle">
                                <tr>
                                    <th style="width: 5%;">Urutan</th>
                                    <th style="width: 30%;">Nama</th>
                                    <th class="text-center" style="width: 20%;">Unit</th>
                                    <th class="text-center" style="width: 15%;">Status Presensi</th>
                                    <th style="width: 15%;">Waktu Presensi</th>
                                    <th class="text-center" style="width: 15%;"> Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($dataUndangan as $list)
                                    <tr wire:key="data_peserta_{{ $list->id }}">
                                        <td class="text-center">{{ $list->pivot->urutan }}</td>
                                        <td>{{ $list->name }}</td>
                                        <td>{{ $list->unit->nama_unit }}</td>
                                        <td class="text-center"><span
                                                class="badge rounded-pill {{ $list->pivot->presensi == 'belum' ? 'text-bg-danger' : 'text-bg-success' }}">
                                                {{ $list->pivot->presensi }}</span>
                                        </td>
                                        <td>{{ $list->pivot->presensi_at ? \Carbon\Carbon::parse($list->pivot->presensi_at)->locale('id')->translatedFormat('d M Y H:i:s') : '' }}
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button type="button"
                                                    class="btn btn-warning btn-sm {{ $statusEditUndangan == false ? 'disabled' : '' }}"
                                                    data-toggle="tooltip" data-placement="bottom" title="Ubah"
                                                    wire:click="editUndangan({{ $list->pivot->id }})">
                                                    <i class="ti ti-pencil align-middle"></i>
                                                </button>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm {{ $statusEditUndangan == false ? 'disabled' : '' }} {{ $agenda->status == 'Selesai' || Auth::user()->cannot('Patrik-Agenda-Delete') ? 'disabled' : '' }}"
                                                    data-toggle="tooltip" data-placement="bottom" title="Hapus"
                                                    data-bs-toggle="modal" data-bs-target="#modalKonfirmasiHapus"
                                                    wire:click="$set('idYangAkanDihapus', {{ $list->id }})">
                                                    <i class="ti ti-trash align-middle"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $dataUndangan->links(data: ['scrollTo' => false]) }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div wire:ignore.self class="modal fade" id="modalKonfirmasi" tabindex="-1" aria-labelledby="hapusLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form wire:submit.prevent="simpanVerifikasi">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Verifikasi Agenda</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="verifikatorInput" class="form-label">Nama Verifikator</label>
                            <input type="text" class="form-control" id="verifikatorInput"
                                wire:model='verifikator' readonly>
                            @error('verifikator')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="statusPengajuan" class="form-label">Pengajuan</label>
                            <select id="statusPengajuan" required class="form-select" wire:model='statusVerifikasi'
                                @cannot('Patrik-Agenda-Create') disabled @endcannot>
                                <option>Pilih Status</option>
                                <option value="Dijadwalkan">Dijadwalkan</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                            @error('statusVerifikasi')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="noUndangan" class="form-label">No Undangan (Optional)</label>
                            <input type="text" class="form-control" id="noUndangan" wire:model='noUndangan'
                                @cannot('Patrik-Agenda-Create') readonly @endcannot>
                            @error('noUndangan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea class="form-control" id="catatan" cols="10" rows="5" wire:model='catatan'
                                @cannot('Patrik-Agenda-Create') readonly @endcannot></textarea>
                            @error('catatan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click='tutupModal'>Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal uploadNotulen -->
    <div wire:ignore.self class="modal fade" id="modalUpload" tabindex="-1" aria-labelledby="uploadLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form wire:submit.prevent="uploadBerkas" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Berkas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="jenisBerkas" class="form-label">Jenis Berkas</label>
                            <select id="jenisBerkas" required class="form-select" wire:model='jenisBerkas'>
                                <option value="">Pilih</option>
                                <option value="notulen" @disabled($agenda->notulen)>Notulen</option>
                                <option value="daftarHadir" @disabled($agenda->daftar)>Daftar Hadir</option>
                                <option value="materi" @disabled($agenda->materi)>Materi</option>
                                <option value="dokumentasi">Dokumentasi</option>
                            </select>
                            @error('jenisBerkas')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="fileUpload" class="form-label">Berkas</label>
                            <input type="file" class="form-control" id="fileUpload" wire:model='fileUpload'>
                            <small class="text-muted">Format file harus PDF untuk Notulen, Daftar Hadir, dan Materi.
                                Untuk
                                Dokumentasi
                                dapat berupa gambar (JPG, JPEG, PNG) atau PDF. Ukuran maksimal file 5MB.</small>
                            @error('fileUpload')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click='tutupModal'>Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if (!empty($agenda->notulen))
        <!-- Modal Preview Notulen -->
        <div class="modal fade" id="previewModalNotulen" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-body p-0 text-center">
                        {{-- Preview PDF --}}
                        <iframe src="{{ route('agenda.notulen', Crypt::encrypt($agenda->id)) }}" width="100%"
                            height="600px" style="border: none;"></iframe>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (!empty($agenda->daftar))
        <!-- Modal Preview Daftar Hadir -->
        <div class="modal fade" id="previewModalDaftar" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-body p-0 text-center">
                        {{-- Preview PDF --}}
                        <iframe src="{{ route('agenda.daftar', Crypt::encrypt($agenda->id)) }}" width="100%"
                            height="600px" style="border: none;"></iframe>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (!empty($agenda->materi))
        <!-- Modal Preview Materi -->
        <div class="modal fade" id="previewModalMateri" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-body p-0 text-center">
                        {{-- Preview PDF --}}
                        <iframe src="{{ route('agenda.materi', Crypt::encrypt($agenda->id)) }}" width="100%"
                            height="600px" style="border: none;"></iframe>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Preview Undangan -->
    <div wire:ignore.self class="modal fade" id="modalUndangan" tabindex="-1">
        <div class="modal-dialog modal-xl" style="height: 90vh;">
            <div class="modal-content" style="height: 100%;">
                <div class="modal-header">
                    <h5 class="modal-title">Preview Undangan</h5>
                    <div class="d-flex justify-content-end gap-2">
                        <button class="btn btn-danger btn-sm" wire:click="deleteFileUndangan('{{ $agenda->id }}')"
                            wire:loading.attr="disabled">
                            <i class="ti ti-trash"></i>
                        </button>
                        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                            <i class="ti ti-x align-middle"></i>
                        </button>
                    </div>
                </div>
                <div class="modal-body" style="height: 100%;">
                    <iframe src="{{ $undanganUrl }}" style="width:100%;height:100%;" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Preview Daftar Hadir -->
    <div wire:ignore.self class="modal fade" id="modalDaftarHadir" tabindex="-1">
        <div class="modal-dialog modal-xl" style="height: 90vh;">
            <div class="modal-content" style="height: 100%;">
                <div class="modal-header">
                    <h5 class="modal-title">Preview Daftar Hadir</h5>
                    <div class="d-flex justify-content-end gap-2">
                        <button class="btn btn-danger btn-sm"
                            wire:click="deleteFileDaftarHadir('{{ $agenda->id }}')" wire:loading.attr="disabled">
                            <i class="ti ti-trash"></i>
                        </button>
                        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                            <i class="ti ti-x align-middle"></i>
                        </button>
                    </div>
                </div>
                <div class="modal-body" style="height: 100%;">
                    <iframe src="{{ $undanganUrl }}" style="width:100%;height:100%;" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>

    @if (!empty($agenda->gambar))
        <!-- Modal Preview Dokumentasi -->
        <div class="modal fade" id="carouselModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Preview Dokumentasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <!-- Carousel -->
                        <div id="dokCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">

                                @foreach ($agenda->gambar as $i => $item)
                                    <div class="carousel-item {{ $i === 0 ? 'active' : '' }} position-relative">
                                        <!-- Tombol Delete -->
                                        <button class="btn btn-danger btn-sm position-absolute"
                                            style="top: 15px; right: 15px; z-index: 10;" data-toggle="tooltip"
                                            data-placement="bottom" title="Hapus Gambar"
                                            wire:click="deleteGambar('{{ $item->id }}')">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                        <img src="{{ route('agenda.dokumentasi', Crypt::encrypt($item->id)) }}"
                                            class="d-block mx-auto" style="max-height: 600px; object-fit: contain;">
                                    </div>
                                @endforeach

                            </div>

                            <!-- Controls -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#dokCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>

                            <button class="carousel-control-next" type="button" data-bs-target="#dokCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>

                        </div>
                        <!-- End Carousel -->

                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Hapus Nama Undangan-->
    <div wire:ignore.self class="modal fade" id="modalKonfirmasiHapus" tabindex="-1" aria-labelledby="hapusLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus nama undangan ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click='tutupModal'>Batal</button>
                    <button type="button" class="btn btn-danger" wire:click="deleteUndangan">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Set Selesai -->
    <div wire:ignore.self class="modal fade" id="modalKonfirmasiSelesai" tabindex="-1" aria-labelledby="hapusLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin set-Selesai agenda ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click='tutupModal'>Batal</button>
                    <button type="button" class="btn btn-success" wire:click="setSelesai">Set Selesai</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                Livewire.on('tutupModalHapus', () => {
                    const modalHapus = bootstrap.Modal.getInstance(document.getElementById(
                        'modalKonfirmasiHapus'));
                    modalHapus.hide();
                });
            });
        </script>

        <script>
            window.addEventListener('hide-modal', () => {
                const modalInstance = bootstrap.Modal.getInstance(document.getElementById('modalKonfirmasiHapus'));
                if (modalInstance) {
                    modalInstance.hide();
                    document.activeElement.blur();
                }
                const modalKonfirmasi = bootstrap.Modal.getInstance(document.getElementById('modalKonfirmasi'));
                if (modalKonfirmasi) {
                    modalKonfirmasi.hide();
                    document.activeElement.blur();
                }
                const modalUpload = bootstrap.Modal.getInstance(document.getElementById('modalUpload'));
                if (modalUpload) {
                    modalUpload.hide();
                    document.activeElement.blur();
                }
                const modalGambar = bootstrap.Modal.getInstance(document.getElementById('carouselModal'));
                if (modalGambar) {
                    modalGambar.hide();
                    document.activeElement.blur();
                }
                const modalUndangan = bootstrap.Modal.getInstance(document.getElementById('modalUndangan'));
                if (modalUndangan) {
                    modalUndangan.hide();
                    document.activeElement.blur();
                }
                const modalDaftarHadir = bootstrap.Modal.getInstance(document.getElementById('modalDaftarHadir'));
                if (modalDaftarHadir) {
                    modalDaftarHadir.hide();
                    document.activeElement.blur();
                }
                const modalKonfirmasiSelesai = bootstrap.Modal.getInstance(document.getElementById(
                    'modalKonfirmasiSelesai'));
                if (modalKonfirmasiSelesai) {
                    modalKonfirmasiSelesai.hide();
                    document.activeElement.blur();
                }
            });
        </script>

        <script>
            window.addEventListener('show-verifikasi-modal', () => {
                let modal = new bootstrap.Modal(document.getElementById('modalKonfirmasi'));
                modal.show();
            });
        </script>
        <script>
            window.addEventListener('show-upload-modal', () => {
                let modal = new bootstrap.Modal(document.getElementById('modalUpload'));
                modal.show();
            });
        </script>
        <script>
            window.addEventListener('show-undangan-modal', () => {
                let modal = new bootstrap.Modal(document.getElementById('modalUndangan'));
                modal.show();
            });
        </script>
        <script>
            window.addEventListener('show-daftar-modal', () => {
                let modal = new bootstrap.Modal(document.getElementById('modalDaftarHadir'));
                modal.show();
            });
        </script>
    @endpush
</div>
