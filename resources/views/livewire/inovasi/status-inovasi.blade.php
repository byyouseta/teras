<div>
    @if ($bukaDetail)
        <div class="card">
            <div class="card-header">
                <div class="card-title">Detail Pengajuan</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-sm table-borderless table-striped w-100">
                            <tr>
                                <th style="width:25%;">Periode Pengusulan</th>
                                <td>{{ $detailInovasi->periode->tahun }}</td>
                            </tr>
                            <tr>
                                <th>Judul</th>
                                <td>{{ $detailInovasi->judul }}</td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td>{{ $detailInovasi->deskripsi }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if ($detailInovasi->status == 'ditolak')
                                        <span
                                            class="badge rounded-pill text-bg-danger">{{ $detailInovasi->status }}</span>
                                    @elseif($detailInovasi->status == 'diterima')
                                        <span
                                            class="badge rounded-pill text-bg-success">{{ $detailInovasi->status }}</span>
                                    @elseif($detailInovasi->status == 'diajukan')
                                        <span
                                            class="badge rounded-pill text-bg-primary">{{ $detailInovasi->status }}</span>
                                    @elseif($detailInovasi->status == 'draft')
                                        <span
                                            class="badge rounded-pill text-bg-secondary">{{ $detailInovasi->status }}</span>
                                    @elseif($detailInovasi->status == 'dijadwalkan')
                                        <span
                                            class="badge rounded-pill text-bg-info">{{ $detailInovasi->status }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Proposal</th>
                                <td>
                                    @if ($detailInovasi->proposal_word)
                                        <a href="{{ route('inovasi.proposal.show', Crypt::encrypt($detailInovasi->id)) }}"
                                            target="_blank"
                                            rel="noopener noreferrer">{{ $detailInovasi->proposal_word }}</a>
                                    @else
                                        <b><i>Proposal belum dilampirkan</i></b>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Pengusul / Ketua Tim</th>
                                <td>{{ $detailInovasi->pengusul->name }}</td>
                            </tr>
                            <tr>
                                <th>Anggota</th>
                                <td>
                                    @foreach ($detailInovasi->anggota as $listAnggota)
                                        {{ $listAnggota->user->name }}@if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                        </table>
                        <div class="mt-3">
                            <table class="table table-sm">
                                <tr>
                                    <th class="text-center" style="width: 5%;">No</th>
                                    <th style="width: 25%;">Nama Atasan</th>
                                    <th class="text-center" style="width: 20%;">Status</th>
                                    <th style="width: 50%;">Catatan</th>
                                </tr>
                                @foreach ($detailInovasi->approvals as $index => $a)
                                    <tr wire:key="data_atasan_{{ $a->user_id }}">
                                        <td class="text-center">{{ ++$index }}</td>
                                        <td>{{ $a->user->name }}</td>
                                        <td class="text-center">
                                            @if ($a->status == 'rejected')
                                                <span
                                                    class="badge rounded-pill text-bg-danger">{{ $a->status }}</span>
                                            @elseif($a->status == 'approved')
                                                <span
                                                    class="badge rounded-pill text-bg-success">{{ $a->status }}</span>
                                            @elseif($a->status == 'pending')
                                                <span
                                                    class="badge rounded-pill text-bg-secondary">{{ $a->status }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $a->catatan }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="mt-2">
                            <button type="button" class="btn btn-secondary btn-sm"
                                wire:click='tutupDetail'>Tutup</button>
                            @php
                                $semuaApproved = $detailInovasi->approvals->every(fn($a) => $a->status === 'approved');
                            @endphp
                            <button type="button"
                                class="btn btn-primary btn-sm {{ !$semuaApproved ? 'disabled' : '' }}"
                                wire:click='bukaModal' {{ !$semuaApproved ? 'disabled' : '' }}>Jadwal
                                Presentasi</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($openFormModal)
        <div class="card">
            <div class="card-header">
                <div class="card-title">Jadwal Paparan Inovasi</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <form wire:submit='simpanPenilai'>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="modalTanggal" class="form-label">Tanggal</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" id="modalTanggal" autocomplete="off"
                                        wire:model='tanggalPresentasi'
                                        @can('Inovasi-Operator-Create') @else disabled @endcan>
                                </div>
                                @error('tanggalPresentasi')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        @can('Inovasi-Operator-Create')
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formPenilai" class="form-label">Penilai Presentasi</label>
                                    <div class="input-group">
                                        <input type="text" name="" id="formPenilai" class="form-control"
                                            wire:model.live.debounce.300ms='cariPenilai'
                                            placeholder="Ketikkan Nama Penilai">
                                        <select class="form-control" wire:model='namaPenilai'>
                                            <option value="">Pilih</option>
                                            @foreach ($dataPenilai as $a)
                                                <option value="{{ $a->id }}">{{ $a->name }}</option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="btn btn-primary" wire:click='tambahPenilai'>Tambah
                                            Penilai</button>
                                    </div>
                                    @error('namaPenilai')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        @endcan
                        <div class="col-md-12">
                            <div class="mb-3">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered w-100">
                                        <tr>
                                            <th class="text-center" style="width: 5%;">No</th>
                                            <th style="width: 20%;">Nama Penilai</th>
                                            <th class="text-center" style="width: 5%;">Sifat Inovasi</th>
                                            <th class="text-center" style="width: 5%;">Memudahkan</th>
                                            <th class="text-center" style="width: 5%;">Mempercepat</th>
                                            <th class="text-center" style="width: 5%;">Solusi Masalah</th>
                                            <th class="text-center" style="width: 5%;">Manfaat</th>
                                            <th class="text-center" style="width: 5%;">Pengaplikasian</th>
                                            <th class="text-center" style="width: 30%;">Catatan</th>
                                            <th class="text-center" style="width: 10%;">Simpulan</th>
                                            <th class="text-center" style="width: 5%;">Hapus</th>
                                        </tr>
                                        @foreach ($timPenilai as $index => $a)
                                            <tr wire:key="data_penilai_{{ $a['user_id'] }}">
                                                <td class="text-center">{{ ++$index }}</td>
                                                <td>{{ $a['nama'] }}</td>
                                                <td class="text-center" style="width: 5%;">{{ $a['sifat_inovasi'] }}
                                                </td>
                                                <td class="text-center" style="width: 5%;">{{ $a['memudahkan'] }}
                                                </td>
                                                <td class="text-center" style="width: 5%;">{{ $a['mempercepat'] }}
                                                </td>
                                                <td class="text-center" style="width: 5%;">{{ $a['solusi'] }}</td>
                                                <td class="text-center" style="width: 5%;">{{ $a['manfaat'] }}</td>
                                                <td class="text-center" style="width: 5%;">{{ $a['pengaplikasian'] }}
                                                </td>
                                                <td>{{ $a['catatan'] }}</td>
                                                <td class="text-center">
                                                    @if ($a['simpulan'] == 'Tidak Layak')
                                                        <span
                                                            class="badge rounded-pill text-bg-danger">{{ $a['simpulan'] }}</span>
                                                    @elseif($a['simpulan'] == 'Layak dengan Revisi')
                                                        <span
                                                            class="badge rounded-pill text-bg-warning">{{ $a['simpulan'] }}</span>
                                                    @elseif($a['simpulan'] == 'Layak')
                                                        <span
                                                            class="badge rounded-pill text-bg-success">{{ $a['simpulan'] }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-center"><button type="button"
                                                        class="btn btn-sm btn-danger "
                                                        {{ $a['simpulan'] != null ? 'disabled' : '' }}
                                                        wire:click="hapusPenilai('{{ $a['user_id'] }}')">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm"
                                wire:click='tutupModal'>Tutup</button>
                            <button type="submit"
                                class="btn btn-primary btn-sm @cannot('Inovasi-Operator-Create') disabled @endcannot">Simpan</button>

                            @if (session()->has('success'))
                                <label for="success" class="fst-italic ms-5">{{ session('success') }}</label>
                            @endif
                            @if (session()->has('error'))
                                <label for="success"
                                    class="text-danger fst-italic ms-5">{{ session('error') }}</label>
                            @endif
                            @php
                                $semuaVerify =
                                    $detailInovasi->pengujis->every(fn($a) => $a->simpulan === 'layak') ||
                                    $detailInovasi->pengujis->every(fn($a) => $a->simpulan === 'layak dengan revisi');
                            @endphp
                            <div class="float-end">
                                <button type="button"
                                    class="btn btn-danger btn-sm @cannot('Inovasi-Operator-Delete') disabled @endcannot"
                                    wire:click='hapusJadwal' {{ $tanggalPresentasi ? '' : 'disabled' }}>Hapus
                                    Jadwal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="float-start">
                <form class="row g-3">
                    <div class="col-auto ">
                        <label for="periode" class="text align-middle mt-1">Pencarian</label>
                    </div>
                    <div class="col-auto">
                        <input type="text" class="form-control form-control-sm"
                            wire:model.live.debounce.500ms="cariNamaInovasi" placeholder="Cari Nama Inovasi"
                            id="inputCariNamaInovasi">
                    </div>
                    <div class="col-auto">
                        <input type="text" class="form-control form-control-sm"
                            wire:model.live.debounce.500ms="cariPengusul" placeholder="Cari Pengusul"
                            id="inputCariPengusul">
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
                                        <button class="btn btn-success btn-sm" data-toggle="tooltip"
                                            data-placement="bottom" title="Detail Inovasi"
                                            wire:click='detailInovasi({{ $a->id }})'>
                                            <i class="ti ti-info-circle align-middle"></i></button>
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

    <!-- Modal Presentasi -->
    <div wire:ignore.self class="modal fade" id="modalPresentasi" tabindex="-1" aria-labelledby="presentasiLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Jadwalkan Paparan Inovasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus agenda ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click='tutupModal'>Batal</button>
                    <button type="button" class="btn btn-danger" wire:click="presentasiInovasi">Hapus</button>
                </div>
            </div>
        </div>
    </div>


    @push('header')
    @endpush

    @push('scripts')
        <script>
            window.addEventListener('resetCariFields', () => {
                document.getElementById('inputCariNamaInovasi').value = '';
                document.getElementById('inputCariPengsusul').value = '';
            });
        </script>


        <script>
            window.addEventListener('show-modal', () => {
                let modal = new bootstrap.Modal(document.getElementById('modalPresentasi'));
                modal.show();
            });
        </script>
        <script>
            window.addEventListener('hide-modal', () => {
                const modalInstance = bootstrap.Modal.getInstance(document.getElementById('modalPresentasi'));
                if (modalInstance) {
                    modalInstance.hide();
                    document.activeElement.blur();
                }
            });
        </script>
    @endpush

</div>
