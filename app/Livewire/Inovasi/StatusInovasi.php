<?php

namespace App\Livewire\Inovasi;

use App\Models\Inovasi;
use App\Models\PengujiInovasi;
use App\Models\PeriodePengusulan;
use App\Models\PresentasiInovasi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class StatusInovasi extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';

    public $periode;
    public $selectedPeriode;
    public $selectedInovasi;
    public $cariNamaInovasi = '';
    public $cariPengusul = '';
    public $bukaDetail = false;
    public $cariPenilai = '';
    public $dataPenilai = [];
    public $timPenilai = [];
    public $namaPenilai;
    public $tanggalPresentasi;

    public $openFormModal = false;

    public $enablePeriode = true;

    public function rules()
    {
        return [
            'tanggalPresentasi' => 'required|date',
            'timPenilai' => 'required|array|min:1',
        ];
    }

    public function render()
    {
        $query = Inovasi::query();

        if ($this->cariNamaInovasi) {
            $query->where('judul', 'like', '%' . $this->cariNamaInovasi . '%');
        }

        if ($this->cariPengusul) {
            $query->whereHas('pengusul', function ($q) {
                $q->where('name', 'like', '%' . $this->cariPengusul . '%');
            });
        }

        if ($this->selectedPeriode == true) {
            $query->whereHas('periode', function ($q) {
                $q->where('tahun', $this->selectedPeriode);
            });
        }

        $data = $query->orderBy('created_at', 'DESC')->paginate(10);

        if ($this->selectedInovasi) {
            $detailInovasi = Inovasi::findOrFail($this->selectedInovasi);
        } else {
            $detailInovasi = null;
        }

        return view('livewire.inovasi.status-inovasi', compact('data', 'detailInovasi'));
    }

    public function mount()
    {
        $this->selectedPeriode = Carbon::now()->format('Y');
        $this->periode = PeriodePengusulan::orderBy('tahun', 'DESC')->get();
    }

    // Reset pagination setiap kali filter berubah
    public function updatingCariNamaInovasi()
    {
        $this->resetPage();
    }

    public function updatingCariPengusul()
    {
        $this->resetPage();
    }

    public function detailInovasi($id)
    {
        $this->selectedInovasi = $id;

        $this->bukaDetail = true;
    }

    public function tutupDetail()
    {
        $this->reset('selectedInovasi', 'openFormModal');

        $this->bukaDetail = false;
    }

    public function resetCari()
    {
        $this->reset('cariNamaInovasi', 'cariPengusul');
        $this->dispatch('resetCariFields');
    }

    public function bukaModal()
    {
        //Form penilaian Penguji
        $this->openFormModal = true;

        $this->reset('tanggalPresentasi', 'timPenilai');

        $presentasi = PresentasiInovasi::where('inovasi_id', $this->selectedInovasi)->first();
        if ($presentasi) {
            $this->tanggalPresentasi = Carbon::parse($presentasi->tanggal_presentasi)->format('Y-m-d');
        }
        $penguji = PengujiInovasi::where('inovasi_id', $this->selectedInovasi)->get();

        if ($penguji) {
            foreach ($penguji as $list) {
                $this->timPenilai[] = [
                    'id' => $list->id,
                    'user_id' => $list->user_id,
                    'nama' => $list->user->name,
                    'sifat_inovasi' => $list->orisinil_modifikasi,
                    'memudahkan' => $list->memudahkan_pelayanan,
                    'mempercepat' => $list->mempercepat_pelayanan,
                    'solusi' => $list->solusi_masalah,
                    'manfaat' => $list->manfaat,
                    'pengaplikasian' => $list->aplikasi_internal_eksternal,
                    'catatan' => $list->catatan,
                    'simpulan' => $list->simpulan,
                ];
            }
        }

        $this->dispatch('show-penjadwalan');
        // $this->dispatch('show-modal');
    }

    public function tutupModal()
    {
        $this->openFormModal = false;

        $this->reset('tanggalPresentasi', 'timPenilai');
        // $this->dataRuangan = $this->defaultDataRuangan;
        // $this->dataPengundang = $this->defaultDataPengundang;
        // $this->dispatch('hide-modal');
    }

    public function updatedCariPenilai()
    {
        $this->dataPenilai = User::where('name', 'like', '%' . $this->cariPenilai . '%')
            ->limit(5)
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function tambahPenilai()
    {
        // cek apakah nama sudah ada di array $dataAnggota
        $sudahAda = collect($this->timPenilai)
            ->pluck('user_id')
            ->contains(strtolower($this->namaPenilai));

        if ($sudahAda) {
            $this->addError('namaPenilai', 'Penilai dengan nama ini sudah ditambahkan.');
            return;
        }

        $user = User::find($this->namaPenilai);

        $this->timPenilai[] = [
            'id' => null,
            'user_id' => $user->id,
            'nama' => $user->name,
            'sifat_inovasi' => null,
            'memudahkan' => null,
            'mempercepat' => null,
            'solusi' => null,
            'manfaat' => null,
            'pengaplikasian' => null,
            'catatan' => null,
            'simpulan' => null,
        ];

        // dd($this->anggotaTim);
        $this->reset(['namaPenilai']);
    }

    public function hapusPenilai($id)
    {
        $this->timPenilai = array_filter($this->timPenilai, fn($item) => $item['user_id'] != $id);
    }

    public function simpanPenilai()
    {
        $this->validate();

        DB::beginTransaction();
        try {

            $inovasi = Inovasi::find($this->selectedInovasi);
            $inovasi->status = 'dijadwalkan';
            $inovasi->save();
            $presentasi = $inovasi->jadwalPresentasi()->updateOrCreate(
                ['inovasi_id' => $inovasi->id], // kondisi
                [
                    'tanggal_presentasi' => $this->tanggalPresentasi,
                ]
            );

            // ambil semua id user yang baru
            $ids = collect($this->timPenilai)->pluck('user_id')->all();

            // hapus penguji lama yang tidak ada di array baru
            $inovasi->pengujis()->whereNotIn('user_id', $ids)->delete();

            // simpan / update penguji baru
            foreach ($this->timPenilai as $penguji) {
                $inovasi->pengujis()->updateOrCreate(
                    [
                        'inovasi_id' => $inovasi->id,
                        'user_id'    => $penguji['user_id'], // kondisi unik
                    ],
                    [] // kalau ada field tambahan bisa diisi di sini
                );
            }

            DB::commit();

            session()->flash('success', 'Jadwal presentasi berhasil disimpan!');
            // $this->reset('timPenilai', 'tanggalPresentasi');
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Gagal menyimpan jadwal: ' . $th->getMessage());
        }
    }

    public function hapusJadwal()
    {
        $inovasi = Inovasi::find($this->selectedInovasi);

        $inovasi->jadwalPresentasi()->delete();
        $inovasi->pengujis()->delete();
        $inovasi->status = 'diajukan';
        $inovasi->save();

        $this->reset('tanggalPresentasi', 'timPenilai');

        session()->flash('success', 'Jadwal berhasil dihapus!');
    }
}
