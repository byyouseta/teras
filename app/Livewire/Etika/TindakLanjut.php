<?php

namespace App\Livewire\Etika;

use App\Models\PelaporanEtik;
use App\Models\TindakLanjutEtika;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\Session\Session;

class TindakLanjut extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $statusFilter = ''; // '', 'open', 'resolved'
    public $perPage = 10;

    // detail modal
    public $selectedReport;
    public $selectedReportId;
    public $previewUrl;

    public $pelaporan_etik_id;
    public $status_laporan;
    public $tindak_lanjut;
    public $ditindak_lanjuti_oleh;
    public $tanggal_tindak_lanjut;
    public $catatan;
    #
    public $file_tindak_lanjut;

    # Properties for file preview

    public $file_tindak_lanjut_preview;
    public $diselesaikan_oleh;
    public $tanggal_selesai;

    protected $listeners = [
        'reportDeleted' => '$refresh',
    ];

    // Reset page on search/filter change
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->authorize('Etika-Operator-Update');

        $query = PelaporanEtik::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('lokasi', 'like', '%' . $this->search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $this->search . '%')
                    ->orWhere('terlapor_nama', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter === 'open') {
            $query->where('resolved', false);
        } elseif ($this->statusFilter === 'resolved') {
            $query->where('resolved', true);
        }

        $reports = $query->orderBy('created_at', 'desc')->paginate($this->perPage);

        return view('livewire.etika.tindak-lanjut', compact('reports'));
    }

    // buka modal dan load detail
    public function viewReport($id)
    {
        $this->authorize('Etika-Operator-Update');

        $report = PelaporanEtik::findOrFail($id);
        $this->selectedReport = $report;
        $this->selectedReportId = $id;
        $this->file_tindak_lanjut = null;

        $rtl = TindakLanjutEtika::where('pelaporan_etik_id', $id)->first();
        if ($rtl) {
            $this->status_laporan = $rtl->status_laporan;
            $this->tindak_lanjut = $rtl->tindak_lanjut;
            $this->ditindak_lanjuti_oleh = $rtl->ditindak_lanjuti_oleh;
            $this->tanggal_tindak_lanjut = $rtl->tanggal_tindak_lanjut ? Carbon::parse($rtl->tanggal_tindak_lanjut)->format('Y-m-d') : null;
            $this->catatan = $rtl->catatan;
            $this->diselesaikan_oleh = $rtl->diselesaikan_oleh;
            $this->tanggal_selesai = $rtl->tanggal_selesai ? Carbon::parse($rtl->tanggal_selesai)->format('Y-m-d') : null;
            // $this->file_tindak_lanjut = $rtl->file_tindak_lanjut;
        } else {
            // reset form jika tidak ada RTL
            $this->reset([
                'status_laporan',
                'tindak_lanjut',
                'ditindak_lanjuti_oleh',
                'tanggal_tindak_lanjut',
                'catatan',
                'diselesaikan_oleh',
                'tanggal_selesai',
            ]);
        }

        // prepare preview url jika ada file
        if ($report->file_pendukung && Storage::disk('public')->exists($report->file_pendukung)) {
            // gunakan route yang aman (lihat bagian route & controller di bawah)
            $this->previewUrl = route('etika.file.pendukung', ['file' => basename($report->file_pendukung), 'preview' => 1]);
        } else {
            $this->previewUrl = null;
        }

        if ($rtl && $rtl->file_tindak_lanjut && Storage::disk('public')->exists($rtl->file_tindak_lanjut)) {
            // gunakan route yang aman (lihat bagian route & controller di bawah)
            $this->file_tindak_lanjut_preview = route('etika.file.tindak.lanjut', ['file' => basename($rtl->file_tindak_lanjut), 'preview' => 1]);
        } else {
            $this->file_tindak_lanjut_preview = null;
        }

        $this->dispatch('open-report-modal');
    }

    public function markResolved($id)
    {
        $this->authorize('Etika-Operator-Update');

        $report = PelaporanEtik::findOrFail($id);
        $report->resolved = true;
        $report->resolved_at = now();
        $report->save();

        // $this->dispatch('notify', ['type' => 'success', 'message' => 'Laporan ditandai selesai.']);
        session()->flash('success', 'Laporan ditandai selesai.');
    }

    public function deleteReport($id)
    {
        $this->authorize('Etika-Operator-Delete');

        $report = PelaporanEtik::findOrFail($id);

        // hapus file jika ada
        if ($report->file_path && Storage::disk('public')->exists($report->file_path)) {
            Storage::disk('public')->delete($report->file_path);
        }

        $report->delete();

        $this->dispatch('notify', ['type' => 'success', 'message' => 'Laporan dihapus.']);
    }

    // optional: bulk delete
    public function bulkDelete($ids = [])
    {
        if (empty($ids)) return;

        foreach ($ids as $id) {
            $this->deleteReport($id);
        }
    }

    public function saveRTL()
    {
        $this->authorize('Etika-Operator-Create');

        // Validasi input
        $validated = $this->validate([
            'status_laporan' => 'required|string',
            'ditindak_lanjuti_oleh' => 'nullable|string|max:255',
            'tanggal_tindak_lanjut' => 'nullable|date',
            'tindak_lanjut' => 'nullable|string',
            'catatan' => 'nullable|string',

            // File opsional tapi max 5MB
            'file_tindak_lanjut' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',

            // Bila status = selesai, kolom ini wajib
            'diselesaikan_oleh' => 'nullable|string|max:255',
            'tanggal_selesai' => 'nullable|date',
        ]);

        $laporan = $this->selectedReport;

        if (!$laporan) {
            session()->flash('error', 'Laporan tidak ditemukan.');
            return;
        }

        // Proses upload file bila ada
        $filePath = null;

        if ($this->file_tindak_lanjut) {
            $fileName = 'rtl-' . time() . '-' . uniqid() . '.' . $this->file_tindak_lanjut->getClientOriginalExtension();
            $filePath = $this->file_tindak_lanjut->storeAs('etika/tindaklanjut', $fileName, 'public');
        }

        // Jika status = selesai → otomatis isi diselesaikan_oleh & tanggal_selesai
        if ($this->status_laporan === 'selesai') {
            // dd('masuk sini');
            $validated['diselesaikan_oleh'] = $this->diselesaikan_oleh != null || $this->diselesaikan_oleh != '' ? $this->diselesaikan_oleh : Auth::user()->name;
            $validated['tanggal_selesai'] = $this->tanggal_selesai ?? now();
        }

        // Update data laporan di database
        if ($filePath === null) {
            // Cek apakah sudah ada record RTL sebelumnya
            $existingRtl = TindakLanjutEtika::where('pelaporan_etik_id', $this->selectedReportId)->first();
            if ($existingRtl) {
                $filePath = $existingRtl->file_tindak_lanjut; // gunakan file yang sudah ada
            }
        }

        try {
            TindakLanjutEtika::updateOrCreate(['pelaporan_etik_id' => $this->selectedReportId], [
                'status_laporan' => $this->status_laporan,
                'tindak_lanjut' => $this->tindak_lanjut,
                'ditindak_lanjuti_oleh' => $this->ditindak_lanjuti_oleh,
                'tanggal_tindak_lanjut' => $this->tanggal_tindak_lanjut,
                'catatan' => $this->catatan,
                'file_tindak_lanjut' => $filePath,
                'diselesaikan_oleh' => $validated['diselesaikan_oleh'] ?? null,
                'tanggal_selesai' => $validated['tanggal_selesai'] ?? null,
            ]);

            // Notifikasi sukses
            // $this->diselesaikan_oleh = $validated['diselesaikan_oleh'] ?? null;
            // $this->tanggal_selesai = $validated['tanggal_selesai'] ?? null;
            session()->flash('success', 'Tindak lanjut berhasil disimpan!');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal memperbarui laporan: ' . $e->getMessage());
            return;
        }
    }

    public function deleteFileTindakLanjut()
    {
        $this->authorize('Etika-Operator-Delete');

        if (!$this->file_tindak_lanjut_preview) {
            return;
        }

        // Hapus file dari storage
        if ($this->file_tindak_lanjut && Storage::disk('public')->exists($this->file_tindak_lanjut)) {
            Storage::disk('public')->delete($this->file_tindak_lanjut);
        }

        $report = TindakLanjutEtika::where('pelaporan_etik_id', $this->selectedReportId)->first();
        if ($report) {
            $report->file_tindak_lanjut = null;
            $report->save();
        }

        // Reset state Livewire
        $this->file_tindak_lanjut_preview = null;
        $this->file_tindak_lanjut = null;

        session()->flash('success', 'File tindak lanjut berhasil dihapus.');
    }
}
