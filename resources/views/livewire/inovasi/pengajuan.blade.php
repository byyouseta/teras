<div>
    @if ($openFormPengajuan)
        <div class="card">
            <div class="card-header">
                <div class="card-title">Tambah Pengajuan Inovasi</div>
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

                <form wire:submit='simpan' enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="modalJudulInovasi" class="form-label">Judul Inovasi</label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                    id="modalJudulInovasi" wire:model="judul">
                                @error('judul')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="modalDeskripsi" class="form-label">Deskripsi Inovasi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="modalDeskripsi" cols="30"
                                    rows="5" wire:model='deskripsi'></textarea>
                                @error('deskripsi')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="modalPeriode"
                                    class="form-label @error('periodePengusulan') is-invalid @enderror">Periode</label>
                                <select name="" id="modalPeriode" class="form-control"
                                    wire:model='periodePengusulan'>
                                    <option value="">Pilih</option>
                                    @foreach ($dataPeriode as $list)
                                        <option value="{{ $list->id }}">
                                            {{ $list->tahun }}</option>
                                    @endforeach
                                </select>
                                @error('periodePengusulan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="modalProposalWord" class="form-label">Proposal Word</label>
                                {{-- kalau sudah ada file lama --}}
                                @if ($linkProposalWord)
                                    <div class="mb-2 d-flex gap-2">
                                        <a href="{{ route('inovasi.proposal.show', Crypt::encrypt($inovasiId)) }}"
                                            target="_blank" class="btn btn-sm btn-primary">
                                            <i class="ti ti-link"></i> Lihat Proposal
                                        </a>

                                        <button type="button" wire:click="deleteProposal"
                                            class="btn btn-sm btn-danger">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>
                                @endif
                                <input type="file" name="" id="modalProposalWord"
                                    class="form-control @error('proposalWord') is-invalid @enderror"
                                    wire:model='proposalWord' aria-describedby="proposalWordBlock" accept=".doc,.docx">
                                <div id="proposalWordBlock" class="form-text">
                                    Your file must be in word file and maximum size is 2MB.
                                </div>
                                @error('proposalWord')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modalAnggota" class="form-label">Anggota Tim</label>
                                <div class="input-group">
                                    <input type="text" name="" id="modalAnggota" class="form-control"
                                        wire:model.live.debounce.300ms='cariUser' placeholder="Ketikkan Nama Anggota">
                                    <select class="form-control" wire:model='namaAnggota'>
                                        <option value="">Pilih</option>
                                        @foreach ($dataUser as $a)
                                            <option value="{{ $a->id }}">{{ $a->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-primary" wire:click='tambahAnggota'>Tambah
                                        Anggota</button>
                                </div>
                                @error('namaAnggota')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            @if (count($anggotaTim) > 0)
                                <div class="mb-3">
                                    <table class="table table-sm">
                                        <tr>
                                            <th style="width: 5%;">No</th>
                                            <th style="width: 90%;">Nama Anggota</th>
                                            <th style="width: 5%;">Hapus</th>
                                        </tr>
                                        @foreach ($anggotaTim as $index => $tim)
                                            <tr wire:key="data_anggota_{{ $tim['user_id'] }}">
                                                <td>{{ ++$index }}</td>
                                                <td>{{ $tim['nama'] }}</td>
                                                <td><button type="button" class="btn btn-sm btn-danger"
                                                        wire:click="hapusAnggota('{{ $tim['user_id'] }}')">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modalAtasan" class="form-label">Approval Atasan</label>
                                <div class="input-group">
                                    <input type="text" name="" id="modalAtasan" class="form-control"
                                        wire:model.live.debounce.300ms='cariAtasan'
                                        placeholder="Ketikkan Nama Atasan">
                                    <select class="form-control" wire:model='namaAtasan'>
                                        <option value="">Pilih</option>
                                        @foreach ($dataAtasan as $a)
                                            <option value="{{ $a->id }}">{{ $a->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-primary" wire:click='tambahAtasan'>Tambah
                                        Atasan</button>
                                </div>
                                @error('namaAtasan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                @error('atasanTim')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            @if (count($atasanTim) > 0)
                                <div class="mb-3">
                                    <table class="table table-sm">
                                        <tr>
                                            <th style="width: 5%;">No</th>
                                            <th style="width: 20%;">Nama Atasan</th>
                                            <th style="width: 20%;">Status</th>
                                            <th style="width: 50%;">Catatan</th>
                                            <th style="width: 5%;">Hapus</th>
                                        </tr>
                                        @foreach ($atasanTim as $index => $a)
                                            <tr wire:key="data_atasan_{{ $a['user_id'] }}">
                                                <td>{{ ++$index }}</td>
                                                <td>{{ $a['nama'] }}</td>
                                                <td>{{ $a['status'] }}</td>
                                                <td>{{ $a['catatan'] }}</td>
                                                <td><button type="button" class="btn btn-sm btn-danger"
                                                        wire:click="hapusAtasan('{{ $a['user_id'] }}')">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            @endif
                        </div>
                        <div class="col-12 mt-2">
                            <button type="button" class="btn btn-secondary"
                                wire:click='klikPengajuan'>Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="float-start">
                <form class="row g-3">
                    <div class="col-auto">
                        <button type="button"
                            class="btn {{ $openFormPengajuan == 'false' ? 'btn-secondary' : 'btn-primary' }} btn-sm"
                            wire:click='klikPengajuan'>{{ $openFormPengajuan == 'false' ? 'Batal' : 'Tambah' }}</button>
                    </div>
                    <div class="col-auto ">
                        <label for="periode" class="text align-middle mt-1">Pencarian</label>
                    </div>
                    <div class="col-auto">
                        <input type="text" class="form-control form-control-sm"
                            wire:model.live.debounce.500ms="cariNamaInovasi" placeholder="Cari Nama Inovasi"
                            id="inputCariNamaInovasi">
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="resetCari">Reset</button>
                    </div>
                </form>
            </div>

            <div class="float-end">
                <div class="row g-3">
                    <div class="col-auto ">
                        <label for="selectPeriode" class="text align-middle mt-1">Periode</label>
                    </div>
                    <div class="col-auto">
                        <select class="form-control form-control-sm pe-5" id="selectPeriode"
                            wire:model.live.debounce.500ms='selectedPeriode'>
                            @foreach ($periode as $p)
                                <option value="{{ $p->tahun }}"
                                    {{ $selectedPeriode == $p->tahun ? 'selected' : '' }}>
                                    {{ $p->tahun }}
                                </option>
                            @endforeach
                        </select>
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
                    <thead class="align-middle text-center">
                        <tr>
                            <th style="width: 15%;">Nama Inovasi</th>
                            <th style="width: 10%;">Pengusul</th>
                            <th style="width: 40%;">Deskripsi</th>
                            <th style="width: 10%;">Periode</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $a)
                            <tr wire:key="data_inovasi {{ $a->id }}">
                                <td>{{ $a->judul }}</td>
                                <td> {{ $a->pengusul->name }} </td>
                                <td> {{ $a->deskripsi }} </td>
                                <td class="text-center">
                                    {{ $a->periode->tahun }}</td>

                                <td class="text-center">
                                    @if ($a->status == 'ditolak')
                                        <span class="badge rounded-pill text-bg-danger">{{ $a->status }}</span>
                                    @elseif($a->status == 'diterima')
                                        <span class="badge rounded-pill text-bg-success">{{ $a->status }}</span>
                                    @elseif($a->status == 'diajukan')
                                        <span class="badge rounded-pill text-bg-primary">{{ $a->status }}</span>
                                    @elseif($a->status == 'draft')
                                        <span class="badge rounded-pill text-bg-secondary">{{ $a->status }}</span>
                                    @elseif($a->status == 'dijadwalkan')
                                        <span class="badge rounded-pill text-bg-info">{{ $a->status }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button"
                                            class="btn btn-success btn-sm {{ in_array($a->status, ['diajukan', 'diterima']) ? 'disabled' : '' }}"
                                            data-bs-toggle="modal" data-bs-target="#modalKonfirmasiPengajuan"
                                            wire:click="$set('idYangDiajukan', {{ $a->id }})">
                                            <i class="ti ti-send align-middle"></i></button>
                                        <button wire:click="edit({{ $a->id }})" data-toggle="tooltip"
                                            data-placement="bottom" title="Ubah"
                                            class="btn btn-warning btn-sm {{ in_array($a->status, ['diajukan', 'diterima']) ? 'disabled' : '' }}"><i
                                                class="ti ti-pencil align-middle"></i></button>
                                        <button type="button"
                                            class="btn btn-danger btn-sm {{ in_array($a->status, ['diajukan', 'diterima', 'ditolak']) ? 'disabled' : '' }}"
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
                    <button type="button" class="btn btn-danger" wire:click="hapusInovasi">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="modalKonfirmasiPengajuan" tabindex="-1"
        aria-labelledby="pengajuanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda sudah yakin dan mengecek ulang data Inovasi yang akan Anda ajukan?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click='tutupModal'>Batal</button>
                    <button type="button" class="btn btn-danger" wire:click="ajukanInovasi">Ajukan</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            window.addEventListener('hide-modal', () => {
                const modalInstance = bootstrap.Modal.getInstance(document.getElementById('formModal'));
                if (modalInstance) {
                    modalInstance.hide();
                    document.activeElement.blur();
                }
                const modalInstancePengajuan = bootstrap.Modal.getInstance(document.getElementById(
                    'modalKonfirmasiPengajuan'));
                if (modalInstancePengajuan) {
                    modalInstancePengajuan.hide();
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
                    // const modalPengajuan = bootstrap.Modal.getInstance(document.getElementById(
                    //     'modalKonfirmasiPengajuan'));
                    // modalPengajuan.hide();
                });
            });
        </script>
    @endpush

</div>
