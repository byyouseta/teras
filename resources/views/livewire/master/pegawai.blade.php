<div>
    <div class="row">
        <div class="col-sm">
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
                                <label for="periode" class="text align-middle mt-1">Pencarian</label>
                            </div>
                            <div class="col-auto">
                                <input type="text" class="form-control form-control-sm"
                                    wire:model.live.debounce.500ms="cariUser" placeholder="Cari Pegawai" id="cariUser">
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
                                    <th style="width: 20%;">NIP</th>
                                    <th style="width: 20%;">Nama Pegawai</th>
                                    <th style="width: 20%;">Unit</th>
                                    <th style="width: 10%;" class="text-center">Status Aktif</th>
                                    <th style="width: 10%;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $now = new DateTime();
                                $now = $now->format('Y-m-d');
                                ?>
                                @foreach ($data as $a)
                                    <tr wire:key="user-{{ $a->id }}">
                                        <td>{{ $a->username }}</td>
                                        <td>{{ $a->name }}</td>
                                        <td>{{ $a->unit ? $a->unit->nama_unit : '-' }}</td>
                                        <td class="text-center">{{ $a->is_active ? 'Aktif' : 'Tidak Aktif' }}</td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <button wire:click="bukaTampilanRole({{ $a->id }})"
                                                    data-toggle="tooltip" data-placement="bottom" title="User Role"
                                                    class="btn btn-warning btn-primary">
                                                    <i class="ti ti-user-check align-middle"></i>
                                                </button>
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#modalResetPassword"
                                                    wire:click="$set('idYangAkanResetPassword', {{ $a->id }})">
                                                    <i class="ti ti-rotate-2 align-middle"></i>
                                                </button>
                                                <button wire:click="edit({{ $a->id }})" data-toggle="tooltip"
                                                    data-placement="bottom" title="Ubah"
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

        @if ($tampilanRole == true)
            <div class="col-sm">
                <div class="card">
                    <div class="card-header">
                        <div class="float-start card-title">
                            Edit Role untuk User : {{ $name }}
                        </div>
                        <div class="float-end"><button class="btn btn-secondary btn-sm"
                                wire:click='tutupTampilanRole'><i class="ti ti-letter-x"></i> Close</button>
                        </div>
                    </div>
                    <div class="card-body">


                        <div class="mb-3">
                            <table class="table table-sm table-hover">
                                <tr>
                                    <th style="width: 10%;">Select</th>
                                    <th style="width: 90%;">Nama Role</th>
                                </tr>
                                @foreach ($daftarRole as $role)
                                    <tr>
                                        <td><input type="checkbox" class="form-check-input" wire:model="selectedRoles"
                                                value="{{ $role->name }}" id="role-{{ $role->id }}"></td>
                                        <td>{{ $role->name }}</td>
                                    </tr>
                                    {{-- <div class="form-check">

                                    <label class="form-check-label" for="role-{{ $role->id }}">
                                        {{ $role->name }}
                                    </label>
                                </div> --}}
                                @endforeach
                            </table>

                        </div>

                        <button wire:click="simpanRole" class="btn btn-success btn-sm">Simpan</button>

                        @if (session()->has('message'))
                            <div class="alert alert-success mt-2">
                                {{ session('message') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="formModal" tabindex="-1" aria-labelledby="modalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalTitle">{{ $modalTitle }}</h1>
                    <button type="button" class="btn-close" wire:click='tutupModal()'></button>
                </div>
                <form wire:submit="simpan">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="modalNip" class="form-label">NIP/Username</label>
                                    <input type="text" class="form-control" id="modalNip" wire:model="username">
                                    @error('username')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="modalNamaLengkap" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="modalNamaLengkap"
                                        wire:model="name">
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
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

                                <div class="mb-3">
                                    <label for="modalGender" class="form-label">Jenis Kelamin</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="inlineCheckbox1"
                                                value="male" wire:model='gender'>
                                            <label class="form-check-label" for="inlineCheckbox1">Laki-laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="inlineCheckbox2"
                                                value="female" wire:model='gender'>
                                            <label class="form-check-label" for="inlineCheckbox2">Perempuan</label>
                                        </div>
                                        @error('gender')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="modalEmail" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="modalEmail"
                                        wire:model.blur="email">
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="modalAkses" class="form-label">Hak Akses</label>
                                    <select class="form-control" wire:model='level'>
                                        <option value="">Pilih</option>
                                        <option value="admin">Admin</option>
                                        <option value="user">User</option>
                                    </select>
                                    @error('level')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="modalJabatan" class="form-label">Jabatan</label>
                                    <input type="text" class="form-control" id="modalJabatan"
                                        wire:model="jabatan">
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
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            wire:model="active" id="modalEnableUser">
                                        <label class="form-check-label" for="modalEnableUser">
                                            Enable User
                                        </label>
                                    </div>
                                    @error('active')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
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
                    Apakah Anda yakin ingin menghapus Pegawai ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click='tutupModal'>Batal</button>
                    <button type="button" class="btn btn-danger" wire:click="hapus">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Reset Password -->
    <div wire:ignore.self class="modal fade" id="modalResetPassword" tabindex="-1"
        aria-labelledby="resetPasswordLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reset Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin mereset password Pegawai ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click='tutupModal'>Batal</button>
                    <button type="button" class="btn btn-danger" wire:click="resetPassword">Reset Password</button>
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
                const modalInstanceReset = bootstrap.Modal.getInstance(document.getElementById('modalResetPassword'));
                if (modalInstanceReset) {
                    modalInstanceReset.hide();
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
