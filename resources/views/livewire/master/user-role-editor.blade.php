<div>
    <div class="card">
        <div class="card-header">
            <div class="float-start card-title">Role User</div>
            <div class="float-end"><button class="btn btn-secondary btn-sm" wire:click='tutupTampilanRole'>Close</button>
            </div>
        </div>
        <div class="card-body">
            @if ($userId)
                <h5>Edit Role untuk User ID: {{ $userId }}</h5>

                <div class="mb-3">
                    @foreach ($roles as $role)
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" wire:model="selectedRoles"
                                value="{{ $role->name }}" id="role-{{ $role->id }}">
                            <label class="form-check-label" for="role-{{ $role->id }}">
                                {{ $role->name }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <button wire:click="save" class="btn btn-success btn-sm">Simpan</button>

                @if (session()->has('message'))
                    <div class="alert alert-success mt-2">
                        {{ session('message') }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
