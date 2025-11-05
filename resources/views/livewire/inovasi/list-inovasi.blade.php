<div>
    @if ($bukaDetail)
        <div class="card">
            <div class="card-header">
                <div class="card-title">Detail Pengajuan</div>
            </div>
            <div class="card-body">
                <div class="class-row">
                    <div class="col-md-12">
                        <table class="table table-sm table-borderless w-100">
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
                        <div class="mt-2">
                            <button type="button" class="btn btn-secondary btn-sm"
                                wire:click='tutupDetail'>Tutup</button>
                        </div>
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
                            <th style="width: 50%;">Deskripsi</th>
                            <th style="width: 10%;">Periode</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $now = new DateTime();
                        $now = $now->format('Y-m-d');
                        ?>
                        @foreach ($data as $a)
                            <tr wire:key="data_inovasi {{ $a->id }}">
                                <td>{{ $a->judul }}</td>
                                <td> {{ $a->pengusul->name }} </td>
                                <td> {{ $a->deskripsi }} </td>
                                <td class="text-center">
                                    {{ $a->periode->tahun }}</td>
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

    <!-- Modal -->

    @push('header')
    @endpush

    @push('scripts')
    @endpush
</div>
