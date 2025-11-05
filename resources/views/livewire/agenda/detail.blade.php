<x-slot name="title">Detail Agenda</x-slot>
<x-slot name="headerTitle">Detail Agenda</x-slot>

<x-slot name="breadcrumb">
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="#">Agenda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('agenda.list') }}">List</a></li>
        <li class="breadcrumb-item" aria-current="page">Detail</li>
    </ul>
</x-slot>

<div>
    <div class="card">
        <div class="card-header">
            <div class="float-start">
                <form class="row g-3">
                    <div class="col-auto">
                        <a href="{{ route('agenda.list') }}" class="btn btn-primary btn-sm">Kembali</a>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="resetCari">Selesai</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless table-sm">
                    <tr>
                        <th style="width: 15%;">Nama Rapat</th>
                        <td style="width: 35%;">{{ $agenda->nama_agenda }}</td>
                        <th style="width: 15%;">PIC Rapat</th>
                        <td style="width: 35%;">{{ $agenda->userpic->name }}</td>
                    </tr>
                    <tr>
                        <th style="width: 15%;">Tanggal</th>
                        <td style="width: 35%;">
                            {{ \Carbon\Carbon::parse($agenda->tanggal)->locale('id')->translatedFormat('d M Y') }}</td>
                        <th style="width: 15%;">Pengundang Acara</th>
                        <td style="width: 35%;">{{ $agenda->pengundang }}</td>
                    </tr>
                    <tr>
                        <th style="width: 15%;">Waktu</th>
                        <td style="width: 35%;">{{ \Carbon\Carbon::parse($agenda->waktu_mulai)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($agenda->waktu_selesai)->format('H:i') }}</td>
                        <th style="width: 15%;">Peserta / Presensi</th>
                        <td style="width: 35%;">{{ $agenda->user->count() }} /
                            {{ $agenda->user->where('pivot.presensi', 'sudah')->count() }}</td>
                    </tr>
                    <tr>
                        <th style="width: 15%;">Tempat</th>
                        <td style="width: 35%;">{{ $agenda->ruangan->nama }}</td>
                        <th style="width: 15%;">Notulen</th>
                        <td style="width: 35%;">
                            @if (!empty($agenda->notulen))
                                <a href="/notulen/view/{{ $agenda->notulen }} " target="_blank"
                                    class="label label-success"><span class="badge rounded-pill text-bg-success">Lihat
                                        File</span></a>
                            @else
                                <span class="badge rounded-pill text-bg-warning">belum ada Notulen</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 15%;">Keterangan</th>
                        <td style="width: 35%;">{{ $agenda->keterangan }}</td>
                        <th style="width: 15%;">Daftar Hadir</th>
                        <td style="width: 35%;">
                            @if (!empty($agenda->daftar))
                                {{ $agenda->daftar }}
                                <a href="/daftarhadir/view/{{ $agenda->daftar }} " target="_blank"><span
                                        class="badge rounded-pill text-bg-success">Daftar
                                        Hadir Luring</span></a>
                            @else
                                <span class="badge rounded-pill text-bg-warning">belum ada Daftar Hadir Luring</span>
                            @endif
                            <a href="/presensi/hadir/{{ Crypt::encrypt($agenda->id) }}" target="_blank"><span
                                    class="badge rounded-pill text-bg-primary">Daring</span></a>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 15%;">Status</th>
                        <td style="width: 35%;">
                            @if ($agenda->status == 'Pengajuan')
                                <span class="badge rounded-pill text-bg-warning">
                                @elseif($agenda->status == 'Dijadwalkan')
                                    <span class="badge rounded-pill text-bg-success">
                                    @else
                                        <span class="badge rounded-pill text-bg-default">
                            @endif
                            {{ $agenda->status }}</span>
                        </td>
                        <th style="width: 15%;">Materi</th>
                        <td style="width: 35%;">
                            @if (!empty($agenda->materi))
                                {{ $agenda->materi }}
                                <a href="/materi/view/{{ $agenda->materi }} " target="_blank"><span
                                        class="badge rounded-pill text-bg-success"></span> Lihat Materi</a>
                            @else
                                <span class="badge rounded-pill text-bg-warning">belum ada materi</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 15%;">Varifikator</th>
                        <td style="width: 35%;">{{ $agenda->verifikator }}</td>
                        <th style="width: 15%;">Dokumentasi</th>
                        <td style="width: 35%;">
                            @forelse ($agenda->gambar() as $item)
                                <a href="/dokumentasi/view/{{ $item->gambar }} " target="_blank"><span
                                        class="badge rounded-pill text-bg-success">{{ $item->gambar }}</span></a>
                            @empty
                                <span class="badge rounded-pill text-bg-warning">belum ada dokumentasi</span>
                            @endforelse
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 15%;">Catatan</th>
                        <td style="width: 35%;">{{ $agenda->catatan }}</td>
                        <th style="width: 15%;">Undangan</th>
                        <td style="width: 35%;">
                            <a href="/undangan/view/{{ Crypt::encrypt($agenda->id) }}" target="_blank"><span
                                    class="badge rounded-pill text-bg-primary">Undangan</span></a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title">
                Peserta Undangan
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-8">
                    <form wire:submit.prevent='tambahUndangan'>
                        <div class="mb-3">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control form-control-sm w-25"
                                    wire:model.live.debounce.300ms="cariUser" placeholder="Ketik untuk mencari...">
                                <select name="" id="modalPengundang" class="form-control form-control-sm w-50"
                                    wire:model='namaUndangan'>
                                    <option value="">Pilih</option>
                                    @foreach ($dataUser as $u)
                                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                                    @endforeach
                                </select>
                                <input type="number" class="form-control form-control-sm w-20"
                                    placeholder="Urutan Undangan" min="1" step="1" wire:model='urutan'>
                                <button class="btn btn-sm btn-primary" type="submit">Tambah</button>
                            </div>
                            @error('namaUndangan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="col-4">
                    <div class="float-end">
                        <div class="row g-3">
                            <div class="col-auto">
                                <input type="text" class="form-control form-control-sm"
                                    placeholder="Cari Nama Undangan"
                                    wire:model.live.debounce.300ms="cariNamaUndangan" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <hr>
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
                                    <th style="width: 5%;">Urutan</th>
                                    <th style="width: 30%;">Nama</th>
                                    <th style="width: 20%;">Unit</th>
                                    <th style="width: 15%;">Status Presensi</th>
                                    <th style="width: 15%;">Waktu Presensi</th>
                                    <th style="width: 15%;"> Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($dataUndangan as $list)
                                    <tr wire:key="data_peserta {{ $list->id }}">
                                        <td>{{ $list->pivot->urutan }}</td>
                                        <td>{{ $list->name }}</td>
                                        <td>{{ $list->unit->nama_unit }}</td>
                                        <td><span
                                                class="badge rounded-pill {{ $list->pivot->presensi == 'belum' ? 'text-bg-danger' : 'text-bg-success' }}">
                                                {{ $list->pivot->presensi }}</span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($list->pivot->presensi_at)->locale('id')->translatedFormat('d M Y H:i:s') }}
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#modalKonfirmasiHapus"
                                                    wire:click="$set('idYangAkanDihapus', {{ $list->id }})">
                                                    <i class="ph ph-trash align-middle"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $dataUndangan->links(data: ['scrollTo' => false]) }}
                        </div>
                    </div>
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
                    <button type="button" class="btn btn-danger" wire:click="deleteUndangan">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                Livewire.on('tutupModalHapus', () => {
                    const modalHapus = bootstrap.Modal.getInstance(document.getElementById(
                        'modalKonfirmasiHapus'));
                    modalHapus.hide();
                });
            });
        </script>

        <script>
            window.addEventListener('hide-modal', () => {
                const modalInstance = bootstrap.Modal.getInstance(document.getElementById('modalKonfirmasiHapus'));
                if (modalInstance) {
                    modalInstance.hide();
                    document.activeElement.blur();
                }
            });
        </script>
    @endpush
</div>
