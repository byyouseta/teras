<?php

namespace App\Livewire\Agenda;

use App\Models\Agenda;
use App\Models\User;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Detail extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';

    public $agenda;
    public $agendaId;
    public $dataUser;
    public $cariUser = '';
    public $namaUndangan, $urutan;
    public $cariNamaUndangan = '';
    public $idYangAkanDihapus;

    public function mount()
    {
        $id = request()->route('id');
        $this->agendaId = $id;
        $this->agenda = Agenda::findOrFail($id);
        $this->dataUser = User::orderBy('name', 'ASC')->get();
    }

    public function render()
    {
        $agenda = Agenda::with(['user'])->findOrFail($this->agendaId);

        $dataUndangan = $agenda->user()->where('name', 'like', '%' . $this->cariNamaUndangan . '%')

            ->paginate(10);

        $this->urutan = $agenda->user()->count() + 1;

        return view('livewire.agenda.detail', [
            // 'agenda' => $agenda,
            'dataUndangan' => $dataUndangan,
        ]);
    }

    public function updatedCariUser()
    {
        $this->dataUser = User::where('name', 'like', '%' . $this->cariUser . '%')
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function tambahUndangan()
    {
        $this->validate([
            'namaUndangan' => 'required|numeric',
            'urutan' => 'required|numeric',
        ]);

        $agenda = Agenda::findOrFail($this->agendaId);

        // dd($agenda, $this->namaUndangan);

        // cari user berdasarkan nama
        // $user = User::where('name', $this->namaUndangan)->first();

        if (!$this->namaUndangan) {
            session()->flash('error', 'User tidak ditemukan.');
            return;
        }

        // attach ke pivot
        $agenda->user()->attach($this->namaUndangan, [
            'presensi'  => 'belum',
            'urutan'  => $this->urutan
        ]);

        session()->flash('success', 'Undangan berhasil ditambahkan.');
        $this->reset('namaUndangan'); // reset input
    }

    public function deleteUndangan()
    {
        // Cari agenda yang sedang aktif
        $agenda = Agenda::find($this->agendaId);

        if (!$agenda) {
            session()->flash('error', 'Agenda tidak ditemukan.');
            return;
        }

        // Hapus user dari undangan (pivot)
        $agenda->user()->detach($this->idYangAkanDihapus);

        // Reset agar tidak terhapus dua kali secara tak sengaja
        $this->reset('idYangAkanDihapus');

        // Emit JS untuk menutup modal
        $this->dispatch('tutupModalHapus');

        session()->flash('success', 'Undangan berhasil dihapus.');
    }

    public function tutupModal()
    {
        // dd('masuk');
        $this->reset('idYangAkanDihapus');
        $this->dispatch('hide-modal');
    }
}
