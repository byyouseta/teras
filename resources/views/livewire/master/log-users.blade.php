<div>
    <div class="card shadow-sm">
        <div class="card-header">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <h5 class="mb-0 flex-shrink-0">Activity Logs</h5>

                <div class="d-flex align-items-center flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-1 flex-shrink-0">
                        <label class="small mb-0">Dari:</label>
                        <input type="date" wire:model.live="startDate" class="form-control form-control-sm w-auto"
                            style="min-width: 150px;">
                    </div>

                    <div class="d-flex align-items-center gap-1 flex-shrink-0">
                        <label class="small mb-0">Sampai:</label>
                        <input type="date" wire:model.live="endDate" class="form-control form-control-sm w-auto"
                            style="min-width: 150px;">
                    </div>

                    <div class="flex-grow-1">
                        <input type="text" wire:model.live="search" class="form-control form-control-sm"
                            placeholder="Cari deskripsi/log name...">
                    </div>
                </div>
            </div>

        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead class="align-middle">
                        <tr>
                            <th class="text-center" width="5%">#</th>
                            <th>Log Name</th>
                            <th>Description</th>
                            <th>Causer</th>
                            <th>Event</th>
                            <th>Changes</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $index => $log)
                            <tr>
                                <td class="text-center">{{ $logs->firstItem() + $index }}</td>
                                <td>{{ $log->log_name }}</td>
                                <td>{{ $log->description }}</td>
                                <td>
                                    @if ($log->causer)
                                        {{ $log->causer->name ?? 'User #' . $log->causer_id }}
                                    @else
                                        <em>System</em>
                                    @endif
                                </td>
                                <td>{{ $log->event ?? '-' }}</td>
                                <td>
                                    @if ($log->properties->has('attributes'))
                                        <details>
                                            <summary>Lihat</summary>
                                            <pre class="bg-light p-2 rounded small mb-0">{{ json_encode($log->properties['attributes'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                        </details>
                                    @else
                                        <em>-</em>
                                    @endif
                                </td>
                                <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-3 text-muted">Tidak ada log dalam periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-light d-flex justify-content-between align-items-center">
            <div>
                <select wire:model.live="perPage" class="form-select form-select-sm w-auto">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
            <div>
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</div>
