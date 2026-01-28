<div>

    @if ($formUpload)
        <div class="card smooth-toggle {{ $formUpload ? 'show' : '' }}">
            <div class="card-header">
                <div class="card-title">
                    Unggah Data Support untuk Monitoring Penerapan Inovasi
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <form wire:submit.prevent='simpan' enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="modalJenisBukti" class="form-label">Jenis Bukti</label>
                                <div>
                                    <label class="me-3">
                                        <input type="radio" wire:model.live.debounce.100ms="jenisBukti"
                                            value="file"> Upload File
                                    </label>
                                    <label>
                                        <input type="radio" wire:model.live.debounce.100ms="jenisBukti"
                                            value="link"> Input Link
                                    </label>
                                </div>
                            </div>
                            @if ($jenisBukti != null)
                                <div class="mb-3">
                                    <label for="modalfile" class="form-label">File Pendukung</label>
                                    @if ($jenisBukti == 'file')
                                        <input type="file" id="modalfile"
                                            class="form-control @error('fileUpload') is-invalid @enderror"
                                            wire:model.live="fileUpload" aria-describedby="proposalWordBlock">
                                        <div id="proposalWordBlock" class="form-text">
                                            Your file must be in pdf,word,xls,xlsx,ppt,pptx,jpg,jpeg file and maximum
                                            size is
                                            2MB.
                                        </div>
                                    @elseif ($jenisBukti == 'link')
                                        <input type="text"
                                            class="form-control @error('fileUpload') is-invalid @enderror"
                                            wire:model='fileUpload' placeholder="Masukkan link pendukung disini">
                                    @endif

                                    @error('fileUpload')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="modalCatatan" class="form-label">Catatan</label>
                                <textarea class="form-control" cols="30" rows="5" wire:model='catatan' placeholder="Masukkan catatan disini"></textarea>
                                @error('catatan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <button type="button" class="btn btn-secondary btn-sm"
                                wire:click='tutupForm'>Tutup</button>
                            <button type="submit" class="btn btn-primary btn-sm"
                                {{ $detailInovasi->pengusul_id == Auth::user()->id ? '' : 'disabled' }}>
                                Simpan
                            </button>
                            @if (session()->has('success'))
                                <label for="success" class="fst-italic mt-2 ms-2">{{ session('success') }}</label>
                            @endif
                            @if (session()->has('error'))
                                <label for="success"
                                    class="text-danger fst-italic mt-2  ms-2">{{ session('error') }}</label>
                            @endif
                        </form>
                    </div>

                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="table table-sm w-100">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Jenis</th>
                                        <th>Link</th>
                                        <th>Catatan</th>
                                        <th class="text-center">Pembaharuan</th>
                                        <th class="text-center">Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detailInovasi->monitoring as $index => $m)
                                        <tr>
                                            <td class="text-center">{{ ++$index }}</td>
                                            <td>{{ $m->tipe_input }}</td>
                                            <td>
                                                @if ($m->tipe_input === 'link')
                                                    <a href="{{ $m->dokumen }}" target="_blank"><span
                                                            class="badge text-bg-primary"><i class="ti ti-link"></i>
                                                            Lihat</span></a>
                                                @else
                                                    <a href="{{ route('inovasi.file.show', Crypt::encrypt($m->id)) }}"
                                                        target="_blank"><span class="badge text-bg-primary"><i
                                                                class="ti ti-file"></i> Lihat</span></a>
                                                @endif
                                                </span></a>
                                            </td>
                                            <td>{{ $m->catatan }}</td>
                                            <td class="text-center">
                                                {{ \Carbon\Carbon::parse($m->updated_at)->format('d-m-Y H:i:s') }}</td>
                                            <td class="text-center"><button type="button"
                                                    class="btn btn-sm btn-danger {{ $detailInovasi->pengusul_id == Auth::user()->id ? '' : 'disabled' }}"
                                                    wire:click="hapusFile({{ $m->id }})">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </td>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                                            data-placement="bottom" title="Unggah data dukung Inovasi"
                                            wire:click='tampilUpload({{ $a->id }})'>
                                            <i class="ti ti-cloud-upload align-middle"></i></button>
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
