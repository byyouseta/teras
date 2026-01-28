<?php

namespace App\Livewire\Etika;

use App\Models\PelaporanEtik;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class PelaporanEtika extends Component
{
    use WithFileUploads;

    public $anonymous = true;
    public $status; // korban / saksi
    public $nama;
    public $phone;
    public $email;
    public $jabatan;
    public $unit;
    public $id_number;

    public $lokasi;
    public $tanggal;
    public $waktu;

    public $terlapor_nama;
    public $terlapor_jabatan;
    public $terlapor_id;

    public $deskripsi;
    public $orang_terlibat;
    public $saksi;

    public $file; // single file upload; change to array if multiple
    public $agree = false;

    // simple anti-spam (you can replace with reCaptcha)
    public $captchaQuestion;
    public $captchaAnswer;
    public $captchaUser;

    protected $rules = [
        'status' => 'required|in:Korban,Saksi',
        'nama' => 'required_if:anonymous,false|max:255',
        'phone' => 'nullable|numeric|digits_between:10,15',
        'email' => 'nullable|email|max:255',
        'jabatan' => 'nullable|max:255',
        'unit' => 'nullable|max:255',
        'id_number' => 'nullable|max:100',

        'lokasi' => 'required|max:255',
        'terlapor_nama' => 'required|max:255',
        'tanggal' => 'required|date',
        'waktu' => 'required',

        'deskripsi' => 'required|string',
        'agree' => 'accepted',

        'file' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:4096',
        'captchaUser' => 'required',
    ];

    protected $messages = [
        'agree.accepted' => 'Anda harus menyetujui pernyataan persetujuan.',
        'nama.required_if' => 'Nama pelapor diperlukan jika tidak anonim.',
    ];

    public function mount()
    {
        $this->generateCaptcha();
    }

    public function generateCaptcha()
    {
        session()->forget('captcha_sum');

        $a = rand(1, 9);
        $b = rand(1, 9);
        $this->captchaQuestion = "Berapa $a + $b ?";
        session(['captcha_sum' => $a + $b]);
    }

    public function updatedAnonymous($val)
    {
        // reset personal data if switched to anonymous
        if ($val) {
            $this->nama = null;
            $this->phone = null;
            $this->email = null;
        }
    }

    public function submit()
    {
        $this->validate();

        if ((int) $this->captchaUser !== session('captcha_sum')) {
            $this->addError('captchaUser', 'Jawaban salah');
            $this->generateCaptcha();
            return;
        }

        session()->forget('captcha_sum');

        $filePath = null;
        if ($this->file) {
            $name = Str::slug(substr($this->terlapor_nama ?? $this->nama ?? 'file', 0, 40)) . '-' . time() . '.' . $this->file->getClientOriginalExtension();
            $filePath = $this->file->storeAs('etika/pelaporan', $name, 'public');
        }

        $countExistingbyYear = PelaporanEtik::where(
            'created_at',
            '>=',
            now()->startOfYear()
        )->where(
            'created_at',
            '<=',
            now()->endOfYear()
        )->count();
        $noTicket = 'ET-' . now()->format('Y') . '-' . str_pad($countExistingbyYear + 1, 4, '0', STR_PAD_LEFT);

        // simpan ke DB
        $report = PelaporanEtik::create([
            'ticket_no' => $noTicket,
            'anonymous' => $this->anonymous,
            'status' => $this->status,
            'nama' => $this->anonymous ? null : $this->nama,
            'phone' => $this->phone,
            'email' => $this->email,
            'jabatan' => $this->jabatan,
            'unit' => $this->unit,
            'id_number' => $this->id_number,
            'lokasi' => $this->lokasi,
            'tanggal' => $this->tanggal,
            'waktu' => $this->waktu,
            'terlapor_nama' => $this->terlapor_nama,
            'terlapor_jabatan' => $this->terlapor_jabatan,
            'terlapor_id' => $this->terlapor_id,
            'deskripsi' => $this->deskripsi,
            'orang_terlibat' => $this->orang_terlibat,
            'saksi' => $this->saksi,
            'file_pendukung' => $filePath,
            'agree' => $this->agree,
        ]);

        // reset form
        $this->resetExcept('captchaQuestion', 'captchaAnswer');
        $this->generateCaptcha();

        session()->flash('message', 'Laporan berhasil disimpan.');
    }

    public function resetForm()
    {
        $this->reset();
        $this->generateCaptcha();
    }

    public function render()
    {
        return view('livewire.etika.pelaporan-etika');
    }
}
