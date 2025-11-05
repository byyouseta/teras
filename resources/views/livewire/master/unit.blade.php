<div>
    <div class="card">
        <div class="card-header">
            <div class="float-start">
                <form class="row g-3">
                    <div class="col-auto">
                        <button type="button" class="btn btn-primary btn-sm" wire:click='bukaModal()'>Tambah</button>
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
                            wire:model.live.debounce.500ms="cariUnit" placeholder="Cari Unit" id="cariUnit">
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
                    <thead class="align-middle">
                        <tr>
                            <th style="width: 25%;">Nama Unit</th>
                            <th style="width: 60%;">Keterangan</th>
                            <th style="width: 60%;">Diperbaharui</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $now = new DateTime();
                        $now = $now->format('Y-m-d');
                        ?>
                        @foreach ($data as $a)
                            <tr wire:key="unit-{{ $a->id }}">
                                <td>{{ $a->nama_unit }}</td>
                                <td>{{ $a->keterangan }}</td>
                                <td>{{ \Carbon\Carbon::parse($a->updated_at)->locale('id')->translatedFormat('d M Y H:i:s') }}
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <button wire:click="edit({{ $a->id }})" data-toggle="tooltip"
                                            data-placement="bottom" title="Ubah" class="btn btn-warning btn-sm"><i
                                                class="ti ti-pencil align-middle"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalKonfirmasiHapus"
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
                                <label for="modalNamaUnit" class="form-label">Nama Unit</label>
                                <input type="text" class="form-control" id="modalNamaUnit" wire:model="namaUnit">
                                @error('namaUnit')
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

    @push('scripts')
        <script>
            window.addEventListener('resetCariFields', () => {
                document.getElementById('cariUnit').value = '';
            });
        </script>

        <script>
            window.addEventListener('show-add-modal', () => {
                let modal = new bootstrap.Modal(document.getElementById('formModal'));
                modal.show();
            });
        </script>

        <script>
            window.addEventListener('bukaModalEdit', () => {
                document.getElementById("modalTitle").textContent = "Edit Data";

                const modal = new bootstrap.Modal(document.getElementById('formModal'));
                modal.show();

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
