<?php

namespace App\Livewire\Agenda;

use App\Models\Agenda;
use App\Models\Ruangan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Daftar extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';

    public $periode;
    public $cariNamaAgenda = '';
    public $cariTempat = '';
    public $cariPIC = '';

    public $namaAgenda, $ruangan, $keterangan, $pengundang, $tanggal, $waktuMulai, $waktuSelesai;
    public $dataRuangan = [];
    public $dataPengundang = [];
    public $defaultDataRuangan = [];
    public $defaultDataPengundang = [];
    public $cariRuangan, $cariPengundang;

    public $today = false;
    public $agendaStatus = '';

    public $agendaId = '';
    public $idYangAkanDihapus = '';

    public $openFormModal = false;

    protected $rules = [
        'namaAgenda' => 'required|string|max:255',
        'ruangan' => 'required|numeric',
        'pengundang' => 'required|numeric',
        'tanggal' => 'required|date',
        'waktuMulai' => 'required|date_format:H:i',
        'waktuSelesai' => 'required|date_format:H:i',
    ];

    public $enablePeriode = true;

    public function render()
    {
        $query = Agenda::query();

        if ($this->cariNamaAgenda) {
            $query->where('nama_agenda', 'like', '%' . $this->cariNamaAgenda . '%');
        }

        if ($this->cariTempat) {
            $query->whereHas('ruangan', function ($q) {
                $q->where('nama', 'like', '%' . $this->cariTempat . '%');
            });
        }

        if ($this->cariPIC) {
            $query->whereHas('userpic', function ($q) {
                $q->where('name', 'like', '%' . $this->cariPIC . '%');
            });
        }

        if ($this->enablePeriode == true) {
            $query->whereMonth('tanggal', Carbon::parse($this->periode)->format('m'))
                ->whereYear('tanggal', Carbon::parse($this->periode)->format('Y'));
        }

        if ($this->today == true) {
            $query->whereDate('tanggal', Carbon::now()->format('Y-m-d'));
        }

        if ($this->agendaStatus) {
            $query->where('status', $this->agendaStatus);
        }

        $data = $query->orderBy('tanggal', 'DESC')->paginate(10);

        return view('livewire.agenda.daftar', compact('data'));
    }

    public function mount()
    {
        $this->periode = Carbon::now()->format('Y-m');
        $this->dataPengundang = User::orderBy('name', 'ASC')->get();
        $this->dataRuangan = Ruangan::orderBy('nama', 'ASC')->get();

        $this->defaultDataRuangan = $this->dataRuangan;
        $this->defaultDataPengundang = $this->dataPengundang;

        $this->today = request()->query('view') === 'today' ? true : false;
        $this->agendaStatus = request()->query('status') ? request()->query('status') : '';
    }

    // Reset pagination setiap kali filter berubah
    public function updatingCariNamaAgenda()
    {
        $this->resetPage();
    }

    public function updatingCariTempat()
    {
        $this->resetPage();
    }

    public function updatingCariPIC()
    {
        $this->resetPage();
    }

    public function updatedCariRuangan()
    {
        $this->dataRuangan = Ruangan::where('nama', 'like', '%' . $this->cariRuangan . '%')
            ->orderBy('nama', 'ASC')
            ->get();
    }

    public function updatedCariPengundang()
    {
        $this->dataPengundang = User::where('name', 'like', '%' . $this->cariPengundang . '%')
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function enableStatusPeriode()
    {
        $this->enablePeriode = !$this->enablePeriode;
    }

    public function toggleToday()
    {
        $this->today = !$this->today;

        if ($this->today == false) {
            return redirect()->route('agenda.list');
        }
    }

    public function resetCari()
    {
        $this->reset('cariNamaAgenda', 'cariTempat', 'cariPIC');
        $this->dispatch('resetCariFields');
        return redirect()->route('agenda.list');
    }

    public function simpan()
    {
        $this->validate();

        $pengundang = User::find($this->pengundang);

        $simpanAgenda = Agenda::updateOrCreate(
            ['id' => $this->agendaId],
            [
                'nama_agenda' => $this->namaAgenda,
                'tanggal' => Carbon::parse($this->tanggal)->format('Y-m-d'),
                'waktu_mulai' => $this->waktuMulai . ':00',
                'waktu_selesai' => $this->waktuSelesai . ':00',
                'ruangan_id' => $this->ruangan,
                'pic' => Auth::user()->id,
                'pengundang' => $pengundang->name,
                'nip_pengundang' => $pengundang->username,
                'jab_pengundang' => $pengundang->pegawai->jabatan ? $pengundang->pegawai->jabatan : '',
                'keterangan' => $this->keterangan,
                'status' => 'Pengajuan',
            ]
        );

        if ($simpanAgenda) {
            session()->flash('success', 'Agenda berhasil disimpan.');
            $this->resetFormInput();
        } else {
            session()->flash('error', 'Agenda gagal disimpan.');
        }
    }

    public function edit($id)
    {
        $agenda = Agenda::findOrFail($id);

        $pengundang = User::where('username', $agenda->nip_pengundang)
            ->first();
        $this->agendaId = $id;
        $this->namaAgenda = $agenda->nama_agenda;
        $this->tanggal = $agenda->tanggal;
        $this->waktuMulai = Carbon::parse($agenda->waktu_mulai)->format('H:i');
        $this->waktuSelesai = Carbon::parse($agenda->waktu_selesai)->format('H:i');
        $this->ruangan = $agenda->ruangan_id;
        $this->keterangan = $agenda->keterangan;
        $this->pengundang = $pengundang->id;

        $this->dispatch('bukaModalEdit');
    }

    public function bukaModal()
    {
        $this->openFormModal = true;

        $this->dispatch('show-add-modal');
    }

    public function tutupModal()
    {
        $this->openFormModal = false;

        $this->reset('namaAgenda', 'ruangan', 'keterangan', 'pengundang', 'tanggal', 'waktuMulai', 'waktuSelesai', 'agendaId', 'cariRuangan', 'cariPengundang');
        $this->dataRuangan = $this->defaultDataRuangan;
        $this->dataPengundang = $this->defaultDataPengundang;
        $this->dispatch('hide-modal');
    }

    public function hapusAgenda()
    {
        $agenda = Agenda::find($this->idYangAkanDihapus);

        if ($agenda) {
            $agenda->delete();
            session()->flash('success', 'Agenda berhasil dihapus.');
        } else {
            session()->flash('error', 'Agenda tidak ditemukan.');
        }

        // Reset agar tidak terhapus dua kali secara tak sengaja
        $this->reset('idYangAkanDihapus');

        // Emit JS untuk menutup modal
        $this->dispatch('tutupModalHapus');
    }

    public function resetFormInput()
    {
        $this->reset('namaAgenda', 'ruangan', 'keterangan', 'pengundang', 'tanggal', 'waktuMulai', 'waktuSelesai', 'agendaId', 'cariRuangan', 'cariPengundang');
        $this->dataRuangan = $this->defaultDataRuangan;
        $this->dataPengundang = $this->defaultDataPengundang;
        $this->dispatch('agendaDisimpan');
    }
}
