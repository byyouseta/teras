<div>
    <div class="row">

        @if ($daftarPermission)
            <div class="col-md">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title fs-5" id="modalTitle">Tambah Data Permissions</h1>
                    </div>
                    <form wire:submit.prevent="removeSelected">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <p><b>Role</b> : {{ $nama }}</p>
                                </div>
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        {{-- <label for="cariPermission" class="form-label">Permission List</label> --}}
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="cariPermission"
                                                wire:model.live.debounce.300ms='cariPermission'
                                                placeholder="Cari Permission">
                                            <select class="form-control" wire:model='selectedPermission'>
                                                <option value="">Pilih</option>
                                                @foreach ($daftarPermission as $u)
                                                    <option value="{{ $u->id }}">{{ $u->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-success btn-sm"
                                                wire:click='simpanRolePermission'>Tambah</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        {{-- <label for="modalNama" class="form-label">Permission Roles</label> --}}
                                        <input type="text" class="form-control"
                                            wire:model.live.debounce.300ms="cariPermissionRoles"
                                            placeholder="Cari Permission di Roles">
                                        <span class="input-group-text"><i class="ti ti-search"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width:5%;">Select</th>
                                                    <th style="width:95%;">Nama</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($rolePermission)
                                                    @foreach ($rolePermission as $list)
                                                        <tr wire:key="listPermission-{{ $list->id }}">
                                                            <td><input type="checkbox" name="" id=""
                                                                    value="{{ $list->id }}"
                                                                    wire:model.live.debounce.100ms='selectedPermissions'>
                                                            </td>
                                                            <td>{{ $list->name }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        <div class="mt-4">
                                            {{ $rolePermission->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-secondary" wire:click='tutupModal'>Close</button>
                            <button type="submit" class="btn btn-danger"
                                @empty($selectedPermissions) disabled @endempty>Hapus</button>
                            {{-- <button type="submit" class="btn btn-primary">Save</button> --}}
                        </div>
                    </form>
                </div>
            </div>
        @else
            <div class="col-md">
                <div class="card">
                    <div class="card-header">
                        <div class="float-start">
                            <form class="row g-3">
                                <div class="col-auto">
                                    <button type="button" class="btn btn-primary btn-sm"
                                        wire:click='bukaModal()'>Tambah</button>
                                </div>
                            </form>
                        </div>

                        <div class="float-end">
                            <div class="row g-3">
                                <div class="col-auto ">
                                    <label for="cariRuangan" class="text align-middle mt-1">Pencarian</label>
                                </div>
                                <div class="col-auto">
                                    <input type="text" class="form-control form-control-sm"
                                        wire:model.live.debounce.500ms="cariRole" placeholder="Cari Role"
                                        id="cariRole">
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-secondary btn-sm"
                                        wire:click="resetCari">Reset</button>
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
                                        <th style="width: 30%;">Nama</th>
                                        <th style="width: 30%;">Dibuat</th>
                                        <th style="width: 30%;">Diperbaharui</th>
                                        <th style="width: 10%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $now = new DateTime();
                                    $now = $now->format('Y-m-d');
                                    ?>
                                    @foreach ($data as $a)
                                        <tr wire:key="listRole-{{ $a->id }}">
                                            <td>{{ $a->name }}</td>
                                            <td>{{ $a->created_at }}</td>
                                            <td>{{ $a->updated_at }}</td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <button wire:click="listPermission({{ $a->id }})"
                                                        data-toggle="tooltip" data-placement="bottom"
                                                        title="List Permission" class="btn btn-primary btn-sm"><i
                                                            class="ti ti-list align-middle"></i></button>
                                                    <button wire:click="edit({{ $a->id }})"
                                                        data-toggle="tooltip" data-placement="bottom" title="Ubah"
                                                        class="btn btn-warning btn-sm"><i
                                                            class="ti ti-pencil align-middle"></i></button>
                                                    <button type="button" class="btn btn-danger btn-sm"
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
            </div>
        @endif
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
                                <label for="modalNama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="modalNama" wire:model="nama">
                                @error('nama')
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

    <!-- Modal List Permission -->
    <div wire:ignore.self class="modal fade" id="formModalListPermission" tabindex="-1"
        aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalTitle">{{ $modalTitle }}</h1>
                    <button type="button" class="btn-close" wire:click='tutupModal()'></button>
                </div>
                <form wire:submit="simpan">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p><b>Role</b> : {{ $nama }}</p>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    {{-- <label for="modalNama" class="form-label">Pencarian Permission</label> --}}
                                    <input type="text" class="form-control" wire:model="cariPermission"
                                        placeholder="Cari Permission">
                                    <span class="input-group-text"><i class="ti ti-search"></i></span>
                                </div>
                                <table class="table tbl-sm table-striped-columns">
                                    <thead>
                                        <tr>
                                            <th>Select</th>
                                            <th>Nama</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    {{-- <label for="modalNama" class="form-label">Permission Roles</label> --}}
                                    <input type="text" class="form-control" wire:model="cariPermissionRoles"
                                        placeholder="Cari Permission di Roles">
                                    <span class="input-group-text"><i class="ti ti-search"></i></span>
                                </div>
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
                    Apakah Anda yakin ingin menghapus Data ini?
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
                document.getElementById('cariRole').value = '';
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
                const modal = new bootstrap.Modal(document.getElementById('formModal'));
                modal.show();

            });
        </script>

        <script>
            window.addEventListener('bukaModalListPermission', () => {
                const modal = new bootstrap.Modal(document.getElementById('formModalListPermission'));
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
                const modalInstanceList = bootstrap.Modal.getInstance(document.getElementById(
                    'formModalListPermission'));
                if (modalInstanceList) {
                    modalInstanceList.hide();
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
