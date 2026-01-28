<div>
    <div class="card">
        <div class="card-header">
            <div class="float-start">
                <form class="row g-3">
                    <div class="col-auto">
                        <button type="button" class="btn btn-primary btn-sm" wire:click='bukaModal()'>Tambah</button>
                    </div>
                    <div class="col-auto ">
                        <label for="periode" class="text align-middle mt-1">Pencarian</label>
                    </div>
                    <div class="col-auto">
                        <input type="text" class="form-control form-control-sm"
                            wire:model.live.debounce.500ms="cariNamaAgenda" placeholder="Cari Nama Agenda"
                            id="inputNamaAgenda">
                    </div>
                    <div class="col-auto">
                        <input type="text" class="form-control form-control-sm"
                            wire:model.live.debounce.500ms="cariTempat" placeholder="Cari Tempat" id="inputTempat">
                    </div>
                    <div class="col-auto">
                        <input type="text" class="form-control form-control-sm"
                            wire:model.live.debounce.500ms="cariPIC" placeholder="Cari PIC" id="inputPIC">
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="resetCari">Reset</button>
                    </div>
                    <div class="col-auto">

                    </div>
                </form>
            </div>

            <div class="float-end">
                <div class="row g-3">
                    <div class="col-auto">
                        <div class="input-group input-group-sm mb-1">
                            <div class="input-group-text">
                                <input class="form-check-input" type="checkbox" value="" id="checkToday"
                                    wire:click="toggleToday" {{ $today ? 'checked' : '' }}>
                                <label class="form-check-label ms-1" for="checkToday">
                                    Today
                                </label>
                            </div>
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" id="periodeCheck"
                                    aria-label="Checkbox for following text input" {{ $enablePeriode ? 'checked' : '' }}
                                    wire:click="enableStatusPeriode">
                                <label for="periode" class="ms-1">Periode</label>
                            </div>
                            <input type="text" class="form-control form-control-sm" id="periodeInput"
                                placeholder="Periode" name="periode" wire:model.live.debounce.300ms="periode"
                                {{ $enablePeriode ? '' : 'disabled' }} />
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="card-body">
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
                            <th style="width: 15%;">Nama<br>Agenda</th>
                            <th style="width: 10%;">Tanggal</th>
                            <th style="width: 10%;">Waktu<br>Mulai</th>
                            <th style="width: 10%;">Waktu<br>Selesai</th>
                            <th style="width: 10%;">Tempat</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 10%;">PIC</th>
                            <th style="width: 10%;">Diajukan</th>
                            <th style="width: 15%;"> Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $now = new DateTime();
                        $now = $now->format('Y-m-d');
                        ?>
                        @foreach ($data as $a)
                            <tr wire:key="data_agenda {{ $a->id }}">
                                <td>{{ $a->nama_agenda }}</td>
                                <td>{{ \Carbon\Carbon::parse($a->tanggal)->locale('id')->translatedFormat('d M Y') }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($a->waktu_mulai)->format('H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($a->waktu_selesai)->format('H:i') }}</td>
                                <td>{{ $a->ruangan->nama }}</td>
                                <td>
                                    @if ($a->tanggal < $now and $a->status != 'Selesai')
                                        <span class="badge rounded-pill text-bg-danger">{{ $a->status }}</span>
                                    @elseif($a->status == 'Dijadwalkan')
                                        <span class="badge rounded-pill text-bg-success">{{ $a->status }}</span>
                                    @elseif($a->status == 'Pengajuan')
                                        <span class="badge rounded-pill text-bg-warning">{{ $a->status }}</span>
                                    @elseif($a->status == 'Ditolak')
                                        <span class="badge rounded-pill text-bg-secondary">{{ $a->status }}</span>
                                    @else
                                        <span class="badge rounded-pill text-bg-primary">{{ $a->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $a->userpic->name }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($a->created_at)->locale('id')->translatedFormat('d M Y H:i:s') }}
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('agenda.detail', Crypt::encrypt($a->id)) }}"
                                            class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="bottom"
                                            title="Detail">
                                            <i class="ti ti-info-circle align-middle"></i></a>

                                        {{-- <a href="/agenda/edit/{{ Crypt::encrypt($a->id) }}"
                                            class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="bottom"
                                            title="Ubah">
                                            <i class="ph ph-pencil-line align-middle"></i></a> --}}
                                        <button wire:click="edit({{ $a->id }})" data-toggle="tooltip"
                                            data-placement="bottom" title="Ubah" class="btn btn-warning btn-sm"><i
                                                class="ti ti-pencil align-middle"></i></button>
                                        <button type="button"
                                            class="btn btn-danger btn-sm @if ($a->status != 'Pengajuan' && Auth::user()->cannot('Patrik-Agenda-Delete')) disabled @endif"
                                            data-toggle="tooltip" data-placement="bottom" title="Hapus"
                                            data-bs-toggle="modal" data-bs-target="#modalKonfirmasiHapus"
                                            wire:click="$set('idYangAkanDihapus', {{ $a->id }})">
                                            <i class="ti ti-trash align-middle"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $data->links() }}
                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="formModal" tabindex="-1" aria-labelledby="modalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalTitle">Tambah Agenda</h1>
                    <button type="button" class="btn-close" wire:click='tutupModal()'></button>
                </div>
                <form wire:submit="simpan">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="modalNamaAgenda" class="form-label">Nama Agenda</label>
                                    <input type="text" class="form-control" id="modalNamaAgenda"
                                        wire:model="namaAgenda">
                                    @error('namaAgenda')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="modalRuangan" class="form-label">Ruangan</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control form-control-sm"
                                            wire:model.live.debounce.300ms="cariRuangan"
                                            placeholder="Ketik untuk mencari...">
                                        <select name="" id="modalRuangan" class="form-control"
                                            wire:model='ruangan'>
                                            <option value="">Pilih</option>
                                            @foreach ($dataRuangan as $listRuangan)
                                                <option value="{{ $listRuangan->id }}">
                                                    {{ $listRuangan->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('ruangan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="modalKeterangan" class="form-label">Keterangan</label>
                                    <textarea class="form-control" id="modalKeterangan" cols="30" rows="5" wire:model='keterangan'></textarea>
                                    @error('keterangan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="modalPengundang" class="form-label">Pengundang</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control form-control-sm"
                                            wire:model.live.debounce.300ms="cariPengundang"
                                            placeholder="Ketik untuk mencari...">
                                        <select name="" id="modalPengundang" class="form-control"
                                            wire:model='pengundang'>
                                            <option value="">Pilih</option>
                                            @foreach ($dataPengundang as $listPengundang)
                                                <option value="{{ $listPengundang->id }}">{{ $listPengundang->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('pengundang')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="modalTanggal" class="form-label">Tanggal</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="modalTanggal"
                                            autocomplete="off" wire:model='tanggal'>
                                        <span class="input-group-text"><i class="ti ti-calendar-event"></i></span>
                                    </div>
                                    @error('tanggal')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="modalWaktuMulai" class="form-label">Waktu Mulai</label>
                                    <div class="input-group ">
                                        <input type="text" class="form-control" id="modalWaktuMulai"
                                            wire:model='waktuMulai' autocomplete="off">
                                        <span class="input-group-text"><i class="ti ti-calendar-time"></i></span>
                                    </div>
                                    @error('waktuMulai')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="modalWaktuSelesai" class="form-label">Waktu
                                        Selesai</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="modalWaktuSelesai"
                                            autocomplete="off" wire:model='waktuSelesai'>
                                        <span class="input-group-text"><i class="ti ti-calendar-time"></i></span>
                                    </div>
                                    @error('waktuSelesai')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click='tutupModal()'>Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Hapus -->
    <div wire:ignore.self class="modal fade" id="modalKonfirmasiHapus" tabindex="-1" aria-labelledby="hapusLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus agenda ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click='tutupModal'>Batal</button>
                    <button type="button" class="btn btn-danger" wire:click="hapusAgenda">Hapus</button>
                </div>
            </div>
        </div>
    </div>


    @push('header')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/light.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
    @endpush

    @push('scripts')
        <!-- Flatpickr JS -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <!-- Plugin Month Select -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script> <!-- Bahasa Indonesia -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>

        <script>
            flatpickr("#periodeInput", {
                locale: "id", // Aktifkan Bahasa Indonesia
                plugins: [
                    new monthSelectPlugin({
                        shorthand: true, // Jan, Feb, ...
                        dateFormat: "Y-m", // Format yang dikirim ke backend: 2025-07
                        altFormat: "F Y" // Format yang ditampilkan ke user: July 2025
                    })
                ]
            });

            flatpickr("#modalTanggal", {
                dateFormat: "d-m-Y", // Format kirim ke backend: 07-08-2025
                altInput: true, // Tampilkan input alternatif yang lebih user-friendly
                altFormat: "l, j F Y", // Format untuk user: Kamis, 7 Agustus 2025
                locale: "id" // Bahasa Indonesia
            });

            flatpickr("#modalWaktuMulai,#modalWaktuSelesai", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i", // Format yang dikirim ke backend
                altInput: true,
                altFormat: "H:i", // Format yang ditampilkan ke user
                time_24hr: true, // Format waktu 24 jam
                locale: "id"
            });
        </script>

        <script>
            function inisialisasiFlatpickr() {
                flatpickr("#periodeInput", {
                    locale: "id", // Aktifkan Bahasa Indonesia
                    plugins: [
                        new monthSelectPlugin({
                            shorthand: true, // Jan, Feb, ...
                            dateFormat: "Y-m", // Format yang dikirim ke backend: 2025-07
                            altFormat: "F Y" // Format yang ditampilkan ke user: July 2025
                        })
                    ]
                });

                flatpickr("#modalTanggal", {
                    dateFormat: "Y-m-d"
                });

                flatpickr("#modalWaktuMulai", {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    time_24hr: true
                });

                flatpickr("#modalWaktuSelesai", {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    time_24hr: true
                });
            }
        </script>

        <script>
            window.addEventListener('resetCariFields', () => {
                document.getElementById('inputNamaAgenda').value = '';
                document.getElementById('inputTempat').value = '';
                document.getElementById('inputPIC').value = '';
            });
        </script>

        <script>
            window.addEventListener('agendaDisimpan', () => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('formModal'));
                modal.hide(); // Tutup modal
                document.getElementById('modalNamaAgenda').value = '';
                document.getElementById('modalRuangan').value = '';
                document.getElementById('modalKeterangan').value = '';
                document.getElementById('modalPengundang').value = '';
                document.getElementById('modalTanggal').value = '';
                document.getElementById('modalWaktuMulai').value = '';
                document.getElementById('modalWaktuSelesai').value = '';

                inisialisasiFlatpickr();
            });
        </script>

        <script>
            window.addEventListener('show-add-modal', () => {
                let modal = new bootstrap.Modal(document.getElementById('formModal'));
                modal.show();
                inisialisasiFlatpickr();
            });
        </script>

        <script>
            window.addEventListener('bukaModalEdit', () => {
                const modal = new bootstrap.Modal(document.getElementById('formModal'));
                modal.show();

                setTimeout(() => {
                    inisialisasiFlatpickr();
                }, 300); // Tunggu sedikit untuk memastikan elemen Livewire sudah dimasukkan ke DOM
            });
        </script>

        <script>
            window.addEventListener('hide-modal', () => {
                const modalInstance = bootstrap.Modal.getInstance(document.getElementById('formModal'));
                if (modalInstance) {
                    modalInstance.hide();
                    document.activeElement.blur();
                }
            });
        </script>

        <script>
            window.addEventListener('DOMContentLoaded', () => {
                Livewire.on('tutupModalHapus', () => {
                    const modalHapus = bootstrap.Modal.getInstance(document.getElementById(
                        'modalKonfirmasiHapus'));
                    modalHapus.hide();
                });
            });

            inisialisasiFlatpickr();
        </script>
    @endpush

</div>
