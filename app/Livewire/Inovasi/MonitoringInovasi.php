<?php

namespace App\Livewire\Inovasi;

use App\Models\Inovasi;
use App\Models\InovasiMonitoring;
use App\Models\PeriodePengusulan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class MonitoringInovasi extends Component
{
    use WithPagination, WithoutUrlPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $periode;
    public $selectedPeriode;
    public $selectedInovasi;
    public $cariNamaInovasi = '';
    public $cariPengusul = '';

    public $enablePeriode = true;
    public $formUpload = false;
    public $jenisBukti = 'file';
    public $fileUpload;
    public $catatan;

    protected function rules()
    {
        if ($this->jenisBukti === 'file') {
            return [
                'jenisBukti' => 'required|string|in:file,link',
                'fileUpload' => 'required|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg|max:2048',
                'catatan'    => 'required|string|max:1000',
            ];
        } else {
            return [
                'jenisBukti' => 'required|string|in:file,link',
                'fileUpload' => 'required|url|max:1000', // kalau jenisBukti = link
                'catatan'    => 'required|string|max:1000',
            ];
        }
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

        $data = $query->where('status', 'diterima')
            ->orderBy('created_at', 'DESC')->paginate(10);

        if ($this->selectedInovasi) {
            $detailInovasi = Inovasi::findOrFail($this->selectedInovasi);
        } else {
            $detailInovasi = null;
        }

        return view('livewire.inovasi.monitoring-inovasi', compact('data', 'detailInovasi'));
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

    public function resetCari()
    {
        $this->reset('cariNamaInovasi', 'cariPengusul');
        $this->dispatch('resetCariFields');
    }

    public function tampilUpload($id)
    {
        $this->selectedInovasi = $id;
        $this->formUpload = true;
    }

    public function tutupForm()
    {
        $this->reset('selectedInovasi', 'formUpload');
    }

    public function simpan()
    {
        $this->validate();

        try {
            $path = null;

            if ($this->jenisBukti === 'link') {
                $path = $this->fileUpload; // simpan link apa adanya
            } else {

                if ($this->fileUpload) {
                    $path = $this->fileUpload->store('monitoring', 'public');
                }
            }

            InovasiMonitoring::create([
                'inovasi_id'        => $this->selectedInovasi,
                'catatan'           => $this->catatan,
                'dokumen'           => $path,
                'tipe_input'       => $this->jenisBukti,
                'status'            => 'berjalan',
                'tanggal_monitoring' => now(),
            ]);

            $this->reset(['fileUpload', 'catatan', 'jenisBukti']);

            session()->flash('success', 'Data monitoring berhasil disimpan.');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function hapusFile($id)
    {
        $monitoring = InovasiMonitoring::findOrFail($id);

        // cek kalau ada file
        if ($monitoring->file_path && Storage::disk('public')->exists($monitoring->file_path)) {
            Storage::disk('public')->delete($monitoring->file_path);
        }

        // hapus record database
        $monitoring->delete();

        session()->flash('success', 'File berhasil dihapus.');
    }
}
