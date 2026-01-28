<?php

namespace App\Livewire\Agenda;

use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Presensi extends Component
{
    use WithPagination, WithoutUrlPagination;

    public function render()
    {
        $agendas = auth()->user()
            ->agenda()
            ->with(['userpic:id,name', 'ruangan:id,nama'])
            // ->orderBy('status', 'asc')
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('livewire.agenda.presensi', [
            'agendas' => $agendas,
        ]);
    }
}
