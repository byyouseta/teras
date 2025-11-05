<div>
    <div class="card">
        <div class="card-header">
            <div class="float-start">
                <form class="row g-3">
                    <div class="col-auto">
                        <button type="button"
                            class="btn btn-primary btn-sm @cannot('Inovasi-Operator-Create') d-none @endcannot"
                            wire:click='bukaModal()'>Tambah</button>
                    </div>

                </form>
            </div>

            <div class="float-end">
                <div class="row g-3">
                    <div class="col-auto ">
                        <label for="periode" class="text align-middle mt-1">Pencarian</label>
                    </div>
                    <div class="col-auto">
                        <input type="text" class="form-control form-control-sm"
                            wire:model.live.debounce.500ms="cariPeriode" placeholder="Cari Periode" id="cariPeriode">
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="resetCari">Reset</button>
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
                <table class="table table-hover table-sm">
                    <thead class="align-middle text-center">
                        <tr>
                            <th style="width: 25%;">Nama Periode</th>
                            <th style="width: 10%;">Tahun</th>
                            <th style="width: 20%;">Mulai</th>
                            <th style="width: 20%;">Selesai</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $a)
                            <tr wire:key="peridoe-{{ $a->id }}">
                                <td>{{ $a->nama_periode }}</td>
                                <td class="text-center">{{ $a->tahun }}</td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($a->mulai)->locale('id')->translatedFormat('d M Y') }}
                                </td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($a->selesai)->locale('id')->translatedFormat('d M Y') }}
                                </td>
                                <td class="text-center">
                                    @if ($a->status == 'open')
                                        <span class="badge bg-success">
                                        @else
                                            <span class="badge bg-danger">
                                    @endif
                                    {{ $a->status }}</span>
                                </td>

                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <button wire:click="edit({{ $a->id }})" data-toggle="tooltip"
                                            data-placement="bottom" title="Ubah"
                                            class="btn btn-warning btn-sm @cannot('Inovasi-Operator-Update') d-none @endcannot"><i
                                                class="ti ti-pencil align-middle"></i></button>
                                        <button type="button"
                                            class="btn btn-danger btn-sm @cannot('Inovasi-Operator-Delete') d-none @endcannot"
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
                    {{ $data->links(data: ['scrollTo' => false]) }}
                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="formModal" tabindex="-1" aria-labelledby="modalTitle"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalTitle">{{ $modalTitle }}</h1>
                    <button type="button" class="btn-close" wire:click='tutupModal()'></button>
                </div>
                <form wire:submit="simpan">
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3">
                                <label for="modalNamaPeriode" class="form-label">Nama Periode</label>
                                <input type="text" class="form-control" id="modalNamaPeriode"
                                    wire:model="namaPeriode">
                                @error('namaPeriode')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="modalTahun" class="form-label">Tahun</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="modalTahun" min="2000"
                                        max="3000" step="1" autocomplete="off" wire:model='tahun'>
                                    <span class="input-group-text"><i class="ti ti-calendar"></i></span>
                                </div>
                                @error('tahun')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="modalTanggalMulai" class="form-label">Tanggal Mulai</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="modalTanggalMulai"
                                        autocomplete="off" wire:model='mulai'>
                                    <span class="input-group-text"><i class="ti ti-calendar"></i></span>
                                </div>
                                @error('mulai')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="modalTanggalSelesai" class="form-label">Tanggal Selesai</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="modalTanggalSelesai"
                                        autocomplete="off" wire:model='selesai'>
                                    <span class="input-group-text"><i class="ti ti-calendar"></i></span>
                                </div>
                                @error('selesai')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="modalStatus" class="form-label">Status Aktif</label>
                                <select class="form-control" id="modalStatus" wire:model="status">
                                    <option value="open">Open</option>
                                    <option value="close">Close</option>
                                </select>
                                @error('status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click='tutupModal'>Close</button>
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
                    Apakah Anda yakin ingin menghapus unit ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click='tutupModal'>Batal</button>
                    <button type="button" class="btn btn-danger" wire:click="hapus">Hapus</button>
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
            // flatpickr("#modalTahun", {
            //     locale: "id"
            //     plugins: [
            //         new monthSelectPlugin({
            //             shorthand: true,
            //             dateFormat: "Y", // hanya tahun yang dikirim ke backend
            //             altFormat: "Y", // hanya tahun yang ditampilkan ke user
            //             theme: "light" // bisa "light" atau "dark"
            //         })
            //     ]
            // });

            flatpickr("#modalTanggalMulai,#modalTanggalSelesai", {
                locale: "id"
                enableTime: false,
                dateFormat: "d-m-Y", // Format yang dikirim ke backend
                altInput: true,
                altFormat: "d-m-Y", // Format yang ditampilkan ke user// Format waktu 24 jam
            });
        </script>

        <script>
            document.addEventListener("livewire:navigated", function() {
                inisialisasiFlatpickr();
            });

            document.addEventListener("livewire:load", function() {
                inisialisasiFlatpickr();
            });

            function inisialisasiFlatpickr() {
                // if (document.querySelector("#modalTahun")._flatpickr) {
                //     document.querySelector("#modalTahun")._flatpickr.destroy();
                // }
                if (document.querySelector("#modalTanggalMulai")._flatpickr) {
                    document.querySelector("#modalTanggalMulai")._flatpickr.destroy();
                }
                if (document.querySelector("#modalTanggalSelesai")._flatpickr) {
                    document.querySelector("#modalTanggalSelesai")._flatpickr.destroy();
                }

                // flatpickr("#modalTahun", {
                //     locale: "id",
                //     plugins: [
                //         new monthSelectPlugin({
                //             shorthand: true,
                //             dateFormat: "Y", // hanya tahun yang dikirim ke backend
                //             altFormat: "Y", // hanya tahun yang ditampilkan ke user
                //             theme: "light" // bisa "light" atau "dark"
                //         })
                //     ]
                // });

                flatpickr("#modalTanggalMulai", {
                    locale: "id",
                    shorthand: true,
                    dateFormat: "Y-m-d", // hanya tahun
                    altFormat: "Y-m-d"
                });

                flatpickr("#modalTanggalSelesai", {
                    locale: "id",
                    shorthand: true,
                    dateFormat: "Y-m-d", // hanya tahun
                    altFormat: "Y-m-d"
                });
            }
        </script>



        <script>
            window.addEventListener('resetCariFields', () => {
                document.getElementById('cariPeriode').value = '';
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
                document.getElementById("modalTitle").textContent = "Edit Data";

                const modal = new bootstrap.Modal(document.getElementById('formModal'));
                modal.show();

                inisialisasiFlatpickr();
            });
        </script>

        <script>
            window.addEventListener('hide-modal', () => {
                const modalInstance = bootstrap.Modal.getInstance(document.getElementById('formModal'));
                if (modalInstance) {
                    modalInstance.hide();
                    document.activeElement.blur();
                }
                const modalInstanceHapus = bootstrap.Modal.getInstance(document.getElementById('modalKonfirmasiHapus'));
                if (modalInstanceHapus) {
                    modalInstanceHapus.hide();
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
        </script>
    @endpush
</div>
