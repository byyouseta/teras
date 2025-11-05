<?php

namespace App\Livewire\Inovasi;

use App\Models\ApprovalInovasi;
use App\Models\Inovasi;
use App\Models\PeriodePengusulan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Pengajuan extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';

    use WithFileUploads;

    public $judul, $periodePengusulan, $deskripsi, $proposalPdf, $proposalWord, $supportingFiles;
    public $dataPeriode = [];
    public $cariUser = '';
    public $dataUser = [];
    public $anggotaTim = [];
    public $namaAnggota;
    public $cariAtasan = '';
    public $dataAtasan = [];
    public $atasanTim = [];
    public $namaAtasan;

    public $periode, $selectedPeriode;
    public $cariNamaInovasi = '';

    public $inovasiId = '';
    public $linkProposalWord;
    public $idYangAkanDihapus = '';
    public $idYangDiajukan = '';

    public $openFormPengajuan = false;

    public function rules()
    {
        return [
            'judul' => 'required|string|max:255',
            'periodePengusulan' => 'required|numeric',
            'deskripsi' => 'required',
            // 'proposalWord' => 'nullable|file|mimes:doc,docx|max:2048', //2MB
            'proposalWord' => $this->inovasiId
                ? 'nullable|file|mimes:doc,docx|max:2048' // update: boleh kosong
                : 'required|file|mimes:doc,docx|max:2048', // create: wajib ada
            'atasanTim' => 'array|min:1', // minimal ada 1 anggota
        ];
    }

    public function mount()
    {
        $this->selectedPeriode = Carbon::now()->format('Y');
        $this->periode = PeriodePengusulan::orderBy('tahun', 'DESC')->get();
        $this->dataPeriode = PeriodePengusulan::where('status', 'open')
            ->orderBy('tahun', 'DESC')->get();
    }

    public function klikPengajuan()
    {
        $this->openFormPengajuan = !($this->openFormPengajuan);

        if ($this->inovasiId != '') {
            $this->resetForm();
        }
    }

    public function updatedCariUser()
    {
        $this->dataUser = User::where('name', 'like', '%' . $this->cariUser . '%')
            ->limit(5)
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function tambahAnggota()
    {

        // cek apakah nama sudah ada di array $dataAnggota
        $sudahAda = collect($this->anggotaTim)
            ->pluck('user_id')
            ->contains(strtolower($this->namaAnggota));

        if ($sudahAda) {
            $this->addError('namaAnggota', 'Anggota dengan nama ini sudah ditambahkan.');
            return;
        }

        $user = User::find($this->namaAnggota);

        $this->anggotaTim[] = [
            'id' => null,
            'user_id' => $user->id,
            'nama' => $user->name
        ];

        // dd($this->anggotaTim);
        $this->reset(['namaAnggota']);
    }

    public function hapusAnggota($id)
    {
        $this->anggotaTim = array_filter($this->anggotaTim, fn($item) => $item['user_id'] != $id);
    }

    public function updatedCariAtasan()
    {
        $this->dataAtasan = User::where('name', 'like', '%' . $this->cariAtasan . '%')
            ->limit(5)
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function tambahAtasan()
    {
        // cek apakah nama sudah ada di array $dataAnggota
        $sudahAda = collect($this->atasanTim)
            ->pluck('user_id')
            ->contains($this->namaAtasan);

        if ($sudahAda) {
            $this->addError('namaAtasan', 'Anggota dengan nama ini sudah ditambahkan.');
            return;
        }

        $user = User::find($this->namaAtasan);

        $this->atasanTim[] = [
            'id' => null,
            'user_id' => $user->id,
            'nama' => $user->name,
            'status' => 'pending',
            'catatan' => null,
        ];

        // dd($this->anggotaTim);
        $this->reset(['namaAtasan']);
    }

    public function hapusAtasan($id)
    {
        $this->atasanTim = array_filter($this->atasanTim, fn($item) => $item['user_id'] != $id);
    }

    public function simpan()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            // Simpan file dulu
            if ($this->inovasiId) {
                // Update
                $inovasi = Inovasi::findOrFail($this->inovasiId);

                // hapus file lama jika ada upload baru
                if ($this->proposalWord) {
                    if ($inovasi->proposal_word && Storage::disk('public')->exists($inovasi->proposal_word)) {
                        Storage::disk('public')->delete($inovasi->proposal_word);
                    }
                    $originalName = pathinfo($this->proposalWord->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $this->proposalWord->getClientOriginalExtension();
                    $fileName = Str::slug($originalName) . '_' . uniqid() . '.' . $extension;

                    $proposalWordPath = $this->proposalWord->storeAs('proposals/word', $fileName, 'public');
                } else {
                    $proposalWordPath = $inovasi->proposal_word; // tetap pakai lama
                }

                $inovasi->update([
                    'judul' => $this->judul,
                    'deskripsi' => $this->deskripsi,
                    'pengusul_id' => Auth::user()->id,
                    'periode_pengusulan_id' => $this->periodePengusulan,
                    'proposal_word' => $proposalWordPath,
                ]);

                foreach ($this->anggotaTim as $anggota) {
                    // dd($anggota);
                    if ($anggota && $anggota['id']) {
                        // update anggota lama
                        $inovasi->anggota()
                            ->where('id', $anggota['id'])
                            ->update(['user_id' => $anggota['user_id']]);
                    } else {
                        $inovasi->anggota()->create(
                            [
                                'user_id' => $anggota['user_id'],
                            ]
                        );
                    }
                }

                // dd($this->anggotaTim, $this->atasanTim);

                $ids = collect($this->anggotaTim)->pluck('user_id')->filter();
                // dd($ids, count($ids), $this->anggotaTim, $this->atasanTim);
                if (count($ids)) {
                    $inovasi->anggota()->whereNotIn('user_id', $ids)->delete();
                } else {
                    $inovasi->anggota()->delete();
                }

                foreach ($this->atasanTim as $a) {
                    if ($a && $a['id']) {

                        $inovasi->approvals()
                            ->where('id', $a['id'])
                            ->update(['user_id' => $a['user_id']]);
                    } else {

                        $inovasi->approvals()->create(
                            [
                                'user_id' => $a['user_id'],
                            ]
                        );
                    }
                }

                $idAt = collect($this->atasanTim)->pluck('user_id')->filter()->all();
                if (count($idAt)) {
                    $inovasi->approvals()->whereNotIn('user_id', $idAt)->delete();
                } else {
                    $inovasi->approvals()->delete();
                }
            } else {
                $proposalWordPath = null;
                if ($this->proposalWord) {
                    $originalName = pathinfo($this->proposalWord->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $this->proposalWord->getClientOriginalExtension();
                    $fileName = Str::slug($originalName) . '_' . uniqid() . '.' . $extension;

                    $proposalWordPath = $this->proposalWord->storeAs('proposals/word', $fileName, 'public');
                }

                $inovasi = Inovasi::create(
                    [
                        'judul' => $this->judul,
                        'deskripsi' => $this->deskripsi,
                        'pengusul_id' => Auth::user()->id,
                        'periode_pengusulan_id' => $this->periodePengusulan,
                        'proposal_word' => $proposalWordPath,
                    ]
                );

                // Simpan anggota tim dari array
                foreach ($this->anggotaTim as $a) {
                    $inovasi->anggota()->create([
                        'user_id' => $a['user_id'],
                    ]);
                }

                foreach ($this->atasanTim as $a) {
                    $inovasi->approvals()->create(
                        [
                            'user_id' => $a['user_id'],
                        ]
                    );
                }
            }


            DB::commit();

            session()->flash('success', 'Inovasi berhasil disimpan!');
            $this->resetForm();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Gagal menyimpan inovasi: ' . $th->getMessage());
        }
    }

    public function render()
    {
        $query = Inovasi::query();

        if ($this->cariNamaInovasi) {
            $query->where('judul', 'like', '%' . $this->cariNamaInovasi . '%');
        }

        if ($this->selectedPeriode) {
            $query->whereHas('periode', function ($q) {
                $q->where('tahun', $this->selectedPeriode);
            });
        }

        $data = $query->where('pengusul_id', Auth::user()->id)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('livewire.inovasi.pengajuan', compact('data'));
    }

    public function resetForm()
    {
        $this->reset(
            'judul',
            'deskripsi',
            'proposalWord',
            'periodePengusulan',
            'atasanTim',
            'anggotaTim',
            'cariUser',
            'cariAtasan',
            'namaAnggota',
            'namaAtasan',
            'anggotaTim',
            'atasanTim',
            'inovasiId',
            'linkProposalWord',
            'idYangDiajukan',
            'idYangAkanDihapus',
            'openFormPengajuan'
        );
        // $this->dataRuangan = $this->defaultDataRuangan;
        // $this->dataPengundang = $this->defaultDataPengundang;
        // $this->dispatch('agendaDisimpan');
    }

    public function resetCari()
    {
        $this->reset('cariNamaInovasi');
        // $this->dispatch('agendaDisimpan');
    }

    public function edit($id)
    {
        $data = Inovasi::findOrFail($id);

        $this->inovasiId = $id;
        $this->judul = $data->judul;
        $this->deskripsi = $data->deskripsi;
        $this->periodePengusulan = $data->periode_pengusulan_id;
        $this->linkProposalWord = $data->proposal_word;

        $this->reset('anggotaTim', 'atasanTim');
        foreach ($data->anggota as $list) {
            $this->anggotaTim[] = [
                'id' => $list->id,
                'user_id' => $list->user->id,
                'nama' => $list->user->name
            ];
        }

        foreach ($data->approvals as $list) {
            $this->atasanTim[] = [
                'id' => $list->id,
                'user_id' => $list->user->id,
                'nama' => $list->user->name,
                'status' => $list->status,
                'catatan' => $list->catatan,
            ];
        }

        // dd($id, $this->atasanTim);

        $this->openFormPengajuan = true;
    }

    public function ajukanInovasi()
    {
        $inovasi = Inovasi::findOrFail($this->idYangDiajukan);

        $inovasi->status = 'diajukan';
        $inovasi->save();

        if ($inovasi) {
            session()->flash('sukses', 'Inovasi berhasil diajukan.');
        } else {
            session()->flash('error', 'Inovasi gagal diajukan.');
        }

        $this->tutupModal();
    }

    public function tutupModal()
    {
        // $this->reset('cariNamaInovasi');
        // $this->dataRuangan = $this->defaultDataRuangan;
        // $this->dataPengundang = $this->defaultDataPengundang;
        $this->resetForm();
        $this->dispatch('hide-modal');
        $this->dispatch('tutupModalHapus');
    }

    public function hapusInovasi()
    {
        if ($this->inovasiId != '') {
            session()->flash('error', 'Data sedang diedit atau baru digunakan');

            // Reset agar tidak terhapus dua kali secara tak sengaja
            $this->reset('idYangAkanDihapus');

            // Emit JS untuk menutup modal
            $this->dispatch('tutupModalHapus');
            return;
        }
        $cariInovasi = Inovasi::find($this->idYangAkanDihapus);

        if ($cariInovasi) {
            $cariInovasi->delete();
            session()->flash('success', 'Data berhasil dihapus.');
        } else {
            session()->flash('error', 'Data tidak ditemukan.');
        }

        // Reset agar tidak terhapus dua kali secara tak sengaja
        $this->reset('idYangAkanDihapus');

        // Emit JS untuk menutup modal
        $this->dispatch('tutupModalHapus');
    }

    public function deleteProposal()
    {
        $inovasi = Inovasi::findOrFail($this->inovasiId);

        if ($inovasi->proposal_word && Storage::disk('public')->exists($inovasi->proposal_word)) {
            Storage::disk('public')->delete($inovasi->proposal_word);
        }

        $inovasi->proposal_word = null;
        $inovasi->save();

        $this->reset('linkProposalWord', 'proposalWord');

        session()->flash('message', 'Proposal berhasil dihapus.');
    }

    public function delete($id)
    {
        $inovasi = Inovasi::findOrFail($id);

        // hapus file juga kalau ada
        if ($inovasi->proposal_word && Storage::disk('public')->exists($inovasi->proposal_word)) {
            Storage::disk('public')->delete($inovasi->proposal_word);
        }

        $inovasi->delete();
    }
}
