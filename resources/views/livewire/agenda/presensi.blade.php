<div>
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
    <div class="card">
        <div class="card-header">
            <div class="float-start">
                <h5>Presensi Agenda</h5>
            </div>
            <div class="float-end">
                <div class="row g-3">
                    <div class="col-auto">
                        <div class="input-group input-group-sm mb-1">
                            <div class="input-group-text">
                                <input class="form-check-input" type="checkbox" value="" id="checkToday"
                                    wire:click="toggleToday">
                                <label class="form-check-label ms-1" for="checkToday">
                                    Today
                                </label>
                            </div>
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" id="periodeCheck"
                                    aria-label="Checkbox for following text input" wire:click="enableStatusPeriode">
                                <label for="periode" class="ms-1">Periode</label>
                            </div>
                            <input type="text" class="form-control form-control-sm" id="periodeInput"
                                placeholder="Periode" name="periode" wire:model.live.debounce.300ms="periode" />
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 20%;">Nama Agenda</th>
                            <th style="width: 10%;">Tanggal</th>
                            <th style="width: 10%;">Waktu Mulai</th>
                            <th style="width: 10%;">Waktu Selesai</th>
                            <th style="width: 10%;">Tempat</th>
                            <th style="width: 10%;">Status Presensi</th>
                            <th style="width: 10%;">Waktu Presensi</th>
                            <th style="width: 10%;">Pengundang</th>
                            <th style="width: 10%;"> Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $now = \Carbon\Carbon::now()->format('Y-m-d');
                        @endphp
                        @forelse ($agendas as $a)
                            <tr>
                                <td>{{ $a->nama_agenda }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($a->tanggal)->format('d M Y') }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($a->waktu_mulai)->format('H:i') }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($a->waktu_selesai)->format('H:i') }}
                                </td>
                                <td>{{ $a->ruangan->nama ?? '' }}</td>
                                @php
                                    $pivot = $a->user->first()?->pivot;
                                @endphp
                                <td class="text-center">
                                    @if ($pivot->presensi == 'sudah')
                                        <span class="badge rounded-pill text-bg-success">
                                        @else
                                            <span class="badge rounded-pill text-bg-danger">
                                    @endif
                                    {{ $pivot->presensi }}</span>
                                </td>
                                <td class="text-center">
                                    {{ $pivot->presensi_at ? \Carbon\Carbon::parse($pivot->presensi_at)->format('H:i:s') : '' }}
                                </td>
                                <td>
                                    {{ $a->pengundang }}
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-info btn-sm" data-toggle="tooltip"
                                            data-placement="bottom" title="Undangan">
                                            <i class="ti ti-file-text"></i>
                                        </button>

                                        <button type="button"
                                            class="btn btn-success btn-sm {{ $pivot->presensi == 'sudah' ? 'disabled' : '' }} {{ $now != $a->tanggal ? 'disabled' : '' }}"
                                            data-toggle="tooltip" data-placement="bottom" title="Presensi">
                                            <i class="ti ti-signature"></i>
                                        </button>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">Belum ada data agenda yang dibuat</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $agendas->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
