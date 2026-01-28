<?php

namespace App\Livewire\Agenda;

use App\Models\Agenda;
use App\Models\Gambar;
use App\Models\Tamu;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Detail extends Component
{
    use WithPagination, WithoutUrlPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $agenda;
    public $agendaId;
    public $dataUser;
    public $cariUser = '';
    public $namaUndangan, $urutan;
    public $cariNamaUndangan = '';

    public $verifikator;
    public $statusVerifikasi;
    public $noUndangan;
    public $catatan;

    public $editNamaUndangan = false;
    public $statusEditUndangan = true;

    public $jenisBerkas;
    public $fileUpload;

    public $tempPdfPath;
    public $undanganUrl;

    public $idYangAkanDihapus;

    public function mount()
    {
        $id = request()->route('id');

        $this->agendaId = Crypt::decrypt($id);
        $this->dataUser = User::orderBy('name', 'ASC')->get();
        $this->verifikator = Auth::user()->name;
    }

    public function render()
    {
        $this->agenda = Agenda::with(['user'])->findOrFail($this->agendaId);

        $dataUndangan = $this->agenda->user()->where('name', 'like', '%' . $this->cariNamaUndangan . '%')
            ->orderBy('pivot_urutan', 'ASC')
            ->paginate(10);

        $this->urutan = $this->agenda->user()->count() + 1;

        $today = Carbon::now()->format('Y-m-d');
        $tanggalAgenda = Carbon::parse($this->agenda->tanggal_agenda)->format('Y-m-d');
        if ($today > $tanggalAgenda) {
            $this->statusEditUndangan = false;
        } else {
            $this->statusEditUndangan = true;
        }

        return view('livewire.agenda.detail', [
            'dataUndangan' => $dataUndangan,
        ]);
    }

    public function updatedCariUser()
    {
        $this->dataUser = User::where('name', 'like', '%' . $this->cariUser . '%')
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function simpanVerifikasi()
    {
        $this->validate([
            'statusVerifikasi' => 'required|string',
            'noUndangan' => 'required|string|max:255',
            'catatan' => 'nullable|string|max:255',
        ]);

        $agenda = Agenda::findOrFail($this->agendaId);

        $agenda->status = $this->statusVerifikasi;
        $agenda->no_undangan = $this->noUndangan;
        $agenda->catatan = $this->catatan;
        $agenda->verifikator = $this->verifikator;
        $agenda->save();

        session()->flash('success', 'Verifikasi agenda berhasil disimpan.');

        $this->dispatch('hide-modal');
    }

    public function tambahUndangan()
    {
        $this->validate([
            'namaUndangan' => 'required|numeric',
            'urutan' => 'required|numeric',
        ]);

        $agenda = Agenda::findOrFail($this->agendaId);

        if (!$this->namaUndangan) {
            session()->flash('error', 'User tidak ditemukan.');
            return;
        }

        if ($agenda->user()->where('user_id', $this->namaUndangan)->exists()) {
            session()->flash('error', 'User sudah diundang.');
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

    public function editUndangan($id)
    {
        $this->editNamaUndangan = true;
        $data = $this->agenda->user()->wherePivot('id', $id)->first();

        // dd($data);

        $this->cariUser = $data->name;
        $this->namaUndangan = $data->id;
        $this->urutan = $data->pivot->urutan;
    }

    public function updateUndangan()
    {
        $this->validate([
            'namaUndangan' => 'required|numeric',
            'urutan' => 'required|numeric',
        ]);

        $agenda = Agenda::findOrFail($this->agendaId);

        if (!$this->namaUndangan) {
            session()->flash('error', 'User tidak ditemukan.');
            return;
        }

        if ($agenda->user()->where('user_id', $this->namaUndangan)->exists()) {
            session()->flash('error', 'User sudah diundang.');
            return;
        }

        // update pivot
        $agenda->user()->updateExistingPivot($this->namaUndangan, [
            'urutan'  => $this->urutan
        ]);

        session()->flash('success', 'Undangan berhasil diupdate.');
        $this->reset('namaUndangan', 'urutan', 'cariUser');
        $this->editNamaUndangan = false;
    }

    public function batalEdit()
    {
        $this->editNamaUndangan = false;
        $this->reset('namaUndangan', 'urutan', 'cariUser');
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
        $this->reset('idYangAkanDihapus', 'jenisBerkas', 'fileUpload');
        $this->dispatch('hide-modal');
    }

    public function verifikasiModal()
    {
        $agenda = Agenda::findOrFail($this->agendaId);

        $this->statusVerifikasi = $agenda->status;
        $this->noUndangan = $agenda->no_undangan;
        $this->catatan = $agenda->catatan;
        if (empty($agenda->verifikator)) {
            $this->verifikator = Auth::user()->name;
        } else {
            $this->verifikator = $agenda->verifikator;
        }

        $this->dispatch('show-verifikasi-modal');
    }

    public function uploadNotulenModal($jenis)
    {
        $this->jenisBerkas = $jenis;
        $this->dispatch('show-upload-modal');
    }

    public function setSelesai()
    {
        $agenda = Agenda::findOrFail($this->agendaId);

        $agenda->status = 'Selesai';
        $agenda->save();

        session()->flash('success', 'Agenda berhasil diset sebagai Selesai.');

        $this->tutupModal();
    }

    public function uploadBerkas()
    {
        $this->validate([
            'jenisBerkas' => 'required|string',
            'fileUpload' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // max 5MB
        ]);

        $agenda = Agenda::findOrFail($this->agendaId);

        $file = $this->fileUpload;

        // ambil ekstensi asli
        $ext = $file->getClientOriginalExtension();

        // buat nama baru 20 karakter
        $newName = Str::random(20) . '.' . $ext;
        // Simpan file
        $this->fileUpload->storeAs('agenda/' . $this->jenisBerkas, $newName, 'public');

        // $filePath = 'agenda/' . $this->jenisBerkas . '/' . $newName;

        if ($this->jenisBerkas == 'notulen') {
            $agenda->notulen = $newName;
            $agenda->save();
        } elseif ($this->jenisBerkas == 'daftarHadir') {
            $agenda->daftar = $newName;
            $agenda->save();
        } elseif ($this->jenisBerkas == 'materi') {
            $agenda->materi = $newName;
            $agenda->save();
        } elseif ($this->jenisBerkas == 'dokumentasi') {
            // Simpan ke tabel gambar agenda
            $agenda->gambar()->create([
                'gambar' => $newName,
            ]);
        }


        session()->flash('success', 'Berkas ' . preg_replace('/(?<!^)([A-Z])/', ' $1', $this->jenisBerkas) . ' berhasil diupload.');

        $this->tutupModal();
    }

    public function hapusBerkas($jenis)
    {
        $this->jenisBerkas = $jenis;

        if ($this->jenisBerkas == 'notulen') {
            $this->hapusNotulen();
        } elseif ($this->jenisBerkas == 'daftarHadir') {
            $this->hapusDaftarHadir();
        } elseif ($this->jenisBerkas == 'materi') {
            $this->hapusMateri();
        }
    }

    public function hapusNotulen()
    {
        $agenda = Agenda::findOrFail($this->agendaId);

        if (!$agenda->notulen) {
            session()->flash('error', 'File notulen tidak ditemukan.');
            return;
        }

        // Hapus file dari storage
        Storage::disk('public')->delete('agenda/notulen/' . $agenda->notulen);

        // Hapus path dari database
        $agenda->notulen = null;
        $agenda->save();

        session()->flash('success', 'File notulen berhasil dihapus.');
    }

    public function hapusDaftarHadir()
    {
        $agenda = Agenda::findOrFail($this->agendaId);

        if (!$agenda->daftar) {
            session()->flash('error', 'File daftar hadir tidak ditemukan.');
            return;
        }

        // Hapus file dari storage
        Storage::disk('public')->delete('agenda/daftarHadir/' . $agenda->daftar);

        // Hapus path dari database
        $agenda->daftar = null;
        $agenda->save();

        session()->flash('success', 'File daftar hadir berhasil dihapus.');
    }

    public function hapusMateri()
    {
        $agenda = Agenda::findOrFail($this->agendaId);

        if (!$agenda->materi) {
            session()->flash('error', 'File materi tidak ditemukan.');
            return;
        }

        // Hapus file dari storage
        Storage::disk('public')->delete('agenda/materi/' . $agenda->materi);

        // Hapus path dari database
        $agenda->materi = null;
        $agenda->save();

        session()->flash('success', 'File materi berhasil dihapus.');
    }

    public function deleteGambar($id)
    {
        $gambar = Gambar::find($id);

        if ($gambar) {
            Storage::disk('public')->delete('agenda/dokumentasi/' . $gambar->gambar);
            $gambar->delete();
        }

        // refresh data
        $this->agenda->refresh();
        $this->tutupModal();
    }

    public function undangan($agendaId)
    {
        $agenda = Agenda::findOrFail($agendaId);

        // Folder penyimpanan
        $folder = 'agenda/undangan/';

        // Buat slug agenda
        $slug = Str::slug($agenda->nama_agenda);

        $hash = substr(md5($agenda->id), 0, 8);
        $filename = "undangan-{$slug}-{$hash}.pdf";

        $path = $folder . $filename;

        if (Storage::disk('public')->exists($path)) {
            $this->undanganUrl = route('agenda.viewUndangan', $filename) . '?r=' . Str::random(6);
            $this->dispatch('show-undangan-modal');
            return;
        }

        $f4 = [0, 0, 595.28, 935.43];
        $pdf = Pdf::loadView('agenda.undangan-pdf', compact('agenda'))
            ->setPaper($f4, 'portrait')
            ->setOption('defaultFont', 'sans-serif');

        Storage::disk('public')->put($path, $pdf->output());

        $this->undanganUrl = route('agenda.viewUndangan', $filename) . '?r=' . Str::random(6);
        $this->dispatch('show-undangan-modal');
    }

    public function daftarhadir($agendaId)
    {
        $agenda = Agenda::findOrFail($agendaId);

        $peserta = $agenda->user()
            ->wherePivot('presensi_at', '!=', '')
            ->get();

        $tamu = Tamu::where('agenda_id', $agendaId)
            ->orderBy('created_at', 'asc')
            ->get();

        // Folder penyimpanan
        $folder = 'agenda/daftarHadir/';

        // Buat slug agenda
        $slug = Str::slug($agenda->nama_agenda);

        $hash = substr(md5($agenda->id), 0, 8);
        $filename = "daftar-hadir-{$slug}-{$hash}.pdf";

        $path = $folder . $filename;

        if (Storage::disk('public')->exists($path)) {
            $this->undanganUrl = route('agenda.viewDaftarHadir', $filename) . '?r=' . Str::random(6);
            $this->dispatch('show-daftar-modal');
            return;
        }

        $f4 = [0, 0, 595.28, 935.43];

        $pdf = Pdf::loadView('agenda.daftarhadir-pdf', compact('agenda', 'peserta', 'tamu'))
            ->setPaper($f4, 'portrait')
            // ... (opsi lainnya)
            ->setOption('defaultFont', 'sans-serif');

        Storage::disk('public')->put($path, $pdf->output());

        $this->undanganUrl = route('agenda.viewDaftarHadir', $filename) . '?r=' . Str::random(6);
        $this->dispatch('show-daftar-modal');
    }

    public function deleteFileUndangan($agendaId)
    {
        $agenda = Agenda::findOrFail($agendaId);

        $slug = Str::slug($agenda->nama_agenda);

        $hash = substr(md5($agenda->id), 0, 8);
        $filename = "undangan-{$slug}-{$hash}.pdf";
        $path = 'agenda/undangan/' . $filename;

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            session()->flash('success', 'File undangan berhasil dihapus.');
            // return true;
            $this->tutupModal();
        } else {
            session()->flash('error', 'File undangan tidak ditemukan.');
        }

        $this->tutupModal();
    }

    public function deleteFileDaftarHadir($agendaId)
    {
        $agenda = Agenda::findOrFail($agendaId);

        $slug = Str::slug($agenda->nama_agenda);

        $hash = substr(md5($agenda->id), 0, 8);
        $filename = "daftar-hadir-{$slug}-{$hash}.pdf";
        $path = 'agenda/daftarHadir/' . $filename;

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            session()->flash('success', 'File daftar hadir berhasil dihapus.');
            // return true;
            $this->tutupModal();
        } else {
            session()->flash('error', 'File daftar hadir tidak ditemukan.');
        }

        $this->tutupModal();
    }
}
