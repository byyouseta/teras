<div>
    @if ($bukaDetail)
        <div class="card">
            <div class="card-header">
                <div class="card-title">Detail Inovasi</div>
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
                        <p class="text-muted mt-5">
                        <h3>Form Penilaian Usulan Inovasi</h3>
                        </p>

                        {{-- Kotak fokus form --}}
                        <div class="card border border-primary rounded-3 shadow-sm p-3 mt-3">
                            <h6 class="card-title mb-3">Formulir Inovasi</h6>

                            <form wire:submit.prevent="simpan">
                                <table class="table">
                                    <tr>
                                        <th>Kriteria</th>
                                        <th class="text-center">Ya</th>
                                        <th class="text-center">Tidak</th>
                                    </tr>
                                    <tr>
                                        <td>Inovasi Bersifat Orisinil / Modifikasi / Pembaruan
                                            @error('orisinilModifikasi')
                                                <br><small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </td>
                                        <td class="text-center"><input type="radio" wire:model="orisinilModifikasi"
                                                value="Ya"></td>
                                        <td class="text-center"><input type="radio" wire:model="orisinilModifikasi"
                                                value="Tidak"></td>
                                    </tr>
                                    <tr>
                                        <td>Memudahkan Pelayanan / Tugas
                                            @error('memudahkanPelayanan')
                                                <br><small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </td>
                                        <td class="text-center"><input type="radio" wire:model="memudahkanPelayanan"
                                                value="Ya"></td>
                                        <td class="text-center"><input type="radio" wire:model="memudahkanPelayanan"
                                                value="Tidak"></td>
                                    </tr>
                                    <tr>
                                        <td>Mempercepat Pelayanan/ Tugas
                                            @error('mempercepatPelayanan')
                                                <br><small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </td>
                                        <td class="text-center"><input type="radio" wire:model="mempercepatPelayanan"
                                                value="Ya"></td>
                                        <td class="text-center"><input type="radio" wire:model="mempercepatPelayanan"
                                                value="Tidak"></td>
                                    </tr>
                                    <tr>
                                        <td>Merupakan Solusi dari Sebuah Masalah
                                            @error('solusi')
                                                <br><small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </td>
                                        <td class="text-center"><input type="radio" wire:model="solusi"
                                                value="Ya">
                                        </td>
                                        <td class="text-center"><input type="radio" wire:model="solusi"
                                                value="Tidak">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Manfaat
                                            @error('manfaat')
                                                <br><small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </td>
                                        <td class="text-center"><input type="radio" wire:model="manfaat"
                                                value="Ya">
                                        </td>
                                        <td class="text-center"><input type="radio" wire:model="manfaat"
                                                value="Tidak">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Bisa Diaplikasikan di Internal / Eksternal
                                            @error('aplikasi')
                                                <br><small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </td>
                                        <td class="text-center">
                                            <input type="radio" wire:model="aplikasi" value="Ya"
                                                class="@error('aplikasi') is-invalid @enderror">
                                        </td>
                                        <td class="text-center">
                                            <input type="radio" wire:model="aplikasi" value="Tidak"
                                                class="@error('aplikasi') is-invalid @enderror">
                                        </td>
                                    </tr>
                                </table>

                                <div class="mt-3 col-md-3">
                                    <label for="formSimpulan">Simpulan</label>
                                    <select wire:model="simpulan" required
                                        class="form-control @error('simpulan') is-invalid @enderror" id="formSimpulan">
                                        <option value="Tidak Layak">Tidak Layak</option>
                                        <option value="Layak dengan Revisi">Layak dengan Revisi</option>
                                        <option value="Layak">Layak</option>
                                    </select>
                                    @error('simpulan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mt-3">
                                    <label>Catatan / Rekomendasi</label>
                                    <textarea wire:model="catatan" class="form-control "></textarea>
                                    @error('catatan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <button type="button" class="btn btn-secondary btn-sm"
                                        wire:click='tutupDetail'>Tutup</button>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        Simpan
                                    </button>
                                    @if (session()->has('success'))
                                        <label for="success"
                                            class="fst-italic ms-5">{{ session('success') }}</label>
                                    @endif
                                    @if (session()->has('error'))
                                        <label for="success"
                                            class="text-danger fst-italic ms-5">{{ session('error') }}</label>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($formKesimpulan)
        <div class="card">
            <div class="card-header">
                <div class="card-title">Rangkuman Nilai</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Penilai</th>
                                    <th class="text-center" style="width: 5%;">Sifat Inovasi</th>
                                    <th class="text-center" style="width: 5%;">Memudahkan</th>
                                    <th class="text-center" style="width: 5%;">Mempercepat</th>
                                    <th class="text-center" style="width: 5%;">Solusi Masalah</th>
                                    <th class="text-center" style="width: 5%;">Manfaat</th>
                                    <th class="text-center" style="width: 5%;">Pengaplikasian</th>
                                    <th class="text-center" style="width: 20%;">Catatan</th>
                                    <th class="text-center" style="width: 20%;">Simpulan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detailInovasi->pengujis as $index => $a)
                                    <tr wire:key="data_penilai_{{ $a['user_id'] }}">
                                        <td>{{ $a->user->name }}</td>
                                        <td class="text-center" style="width: 5%;">{{ $a->orisinil_modifikasi }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">{{ $a->memudahkan_pelayanan }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">{{ $a->mempercepat_pelayanan }}
                                        </td>
                                        <td class="text-center" style="width: 5%;">{{ $a->solusi_masalah }}</td>
                                        <td class="text-center" style="width: 5%;">{{ $a->manfaat }}</td>
                                        <td class="text-center" style="width: 5%;">
                                            {{ $a->aplikasi_internal_eksternal }}
                                        </td>
                                        <td>{{ $a->catatan }}</td>
                                        <td class="text-center">{{ $a->simpulan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card border border-primary rounded-3 shadow-sm p-3 mt-3">
                        <form wire:submit.prevent='simpanStatus'>
                            <div class="col-md-3 mt-3">
                                <label for="statusFinal"
                                    class="form-label @error('statusFinal') is-invalid @enderror">Status Final</label>
                                <select name="" id="statusFinal" class="form-control"
                                    wire:model='statusFinal'>
                                    <option value="">Pilih</option>
                                    <option value="diterima">
                                        Diterima</option>
                                    <option value="ditolak">
                                        Ditolak
                                    </option>
                                </select>
                                @error('statusFinal')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mt-3">
                                <button type="button" class="btn btn-secondary btn-sm"
                                    wire:click='tutupKesimpulan'>Tutup</button>
                                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                @if (session()->has('success'))
                                    <label for="success" class="fst-italic ms-5">{{ session('success') }}</label>
                                @endif
                                @if (session()->has('error'))
                                    <label for="success"
                                        class="text-danger fst-italic ms-5">{{ session('error') }}</label>
                                @endif
                            </div>
                        </form>
                    </div>
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
                                            data-placement="bottom" title="Nilai Usulan Inovasi"
                                            wire:click='detailInovasi({{ $a->id }})'>
                                            <i class="ti ti-pencil align-middle"></i></button>
                                        <button class="btn btn-info btn-sm" data-toggle="tooltip"
                                            data-placement="bottom" title="Summary Nilai Inovasi"
                                            wire:click='kesimpulanInovasi({{ $a->id }})'>
                                            <i class="ti ti-list-numbers align-middle"></i></button>
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
</div>
