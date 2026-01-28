<div>
    @if ($formUpload)
        <div class="card smooth-toggle {{ $formUpload ? 'show' : '' }}">
            <div class="card-header">
                <div class="card-title">
                    Berita Acara Verifikasi Inovasi
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form wire:submit.prevent='simpan'>
                            <div class="mb-3">
                                <label for="modalfile" class="form-label">Nama Inovasi :
                                    {{ $detailInovasi->judul }}</label>
                            </div>
                            <table class="table table-sm table-bordered">
                                <tr>
                                    <th colspan="4">A. JENIS INOVASI</th>
                                </tr>
                                <tr>
                                    <th class="text-center" style="width:5%;">No</th>
                                    <th style="width:30%;">Rincian</th>
                                    <th class="text-center" style="width:15%;">Checklist (Bisa Lebih dari 1)</th>
                                    <th style="width:50%;" class="text-center">Keterangan</th>
                                </tr>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>Kebijakan</td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='kebijakan'>
                                        @error('kebijakan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1" wire:model='keterangan_kebijakan'
                                            {{ $kebijakan ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_kebijakan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td>Teknologi Kesehatan</td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='tek_kes'>
                                        @error('tek_kes')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1" wire:model='keterangan_tek_kes'
                                            {{ $tek_kes ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_tek_kes')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">3</td>
                                    <td>Teknologi Sistem Informasi</td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='tek_si'>
                                        @error('tek_si')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1" wire:model='keterangan_tek_si'
                                            {{ $tek_si ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_tek_si')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">4</td>
                                    <td>Pelayanan Publik</td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='pelayanan_publik'>
                                        @error('pelayanan_publik')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1" wire:model='keterangan_pelayanan_publik'
                                            {{ $pelayanan_publik ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_pelayanan_publik')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">5</td>
                                    <td>Budaya Kerja</td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='budaya_kerja'>
                                        @error('budaya_kerja')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1" wire:model='keterangan_budaya_kerja'
                                            {{ $budaya_kerja ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_budaya_kerja')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">6</td>
                                    <td>Metode Kerja / SOP</td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='sop'>
                                        @error('sop')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1" wire:model='keterangan_sop'
                                            {{ $sop ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_sop')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">7</td>
                                    <td>MoU /Perjanjian</td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='mou'>
                                        @error('mou')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1" wire:model='keterangan_mou'
                                            {{ $mou ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_mou')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">8</td>
                                    <td>Produk / Prototipe</td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='produk'>
                                        @error('produk')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1" wire:model='keterangan_produk'
                                            {{ $produk ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_produk')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="4">B. KRITERIA INOVASI</th>
                                </tr>
                                <tr>
                                    <th class="text-center" style="width:5%;">No</th>
                                    <th style="width:30%;">Rincian</th>
                                    <th class="text-center" style="width:15%;">Cheklist (Bisa Lebih dari 1)</th>
                                    <th style="width:50%;" class="text-center">Keterangan</th>
                                </tr>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>Pembaharuan / Orisinal / Modifikasi</td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='pembaharuan'>

                                        @error('pembaharuan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1" wire:model='keterangan_pembaharuan'
                                            {{ $pembaharuan ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_pembaharuan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td>Memudahkan pelayanan</td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='memudahkan'>

                                        @error('memudahkan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1" wire:model='keterangan_memudahkan'
                                            {{ $memudahkan ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_memudahkan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">3</td>
                                    <td>Mempercepat Pelayanan</td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='mempercepat'>

                                        @error('mempercepat')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1" wire:model='keterangan_mempercepat'
                                            {{ $mempercepat ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_mempercepat')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">4</td>
                                    <td>Disebarluaskan</td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='disebarluaskan'>
                                        @error('disebarluaskan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1" wire:model='keterangan_disebarluaskan'
                                            {{ $disebarluaskan ? '' : 'disabled' }}></textarea>
                                        @error('disebarluaskan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">5</td>
                                    <td>Bermanfaat</td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='bermanfaat'>

                                        @error('bermanfaat')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1" wire:model='keterangan_bermanfaat'
                                            {{ $bermanfaat ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_bermanfaat')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">6</td>
                                    <td>Spesifik</td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='spesifik'>

                                        @error('spesifik')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1" wire:model='keterangan_spesifik'
                                            {{ $spesifik ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_spesifik')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">7</td>
                                    <td>Berkelanjutan</td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='berkelanjutan'>
                                        @error('berkelanjutan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1" wire:model='keterangan_berkelanjutan'
                                            {{ $berkelanjutan ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_berkelanjutan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">8</td>
                                    <td>Solusi / Upaya pemecahan masalah</td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='solusi'>
                                        @error('solusi')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1" wire:model='keterangan_solusi'
                                            {{ $solusi ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_solusi')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">9</td>
                                    <td>Dapat diaplikasikan di Internal / Eksternal</td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='dapat_diaplikasikan'>
                                        @error('dapat_diaplikasikan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1"
                                            wire:model='keterangan_dapat_diaplikasikan' {{ $dapat_diaplikasikan ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_dapat_diaplikasikan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">10</td>
                                    <td>Percontohan Nasional</td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='percontohan'>
                                        @error('percontohan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1" wire:model='keterangan_percontohan'
                                            {{ $percontohan ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_percontohan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="4">C. KATEGORI INOVASI DALAM IMPLEMENTASI SAKIP</th>
                                </tr>
                                <tr>
                                    <th class="text-center" style="width:5%;">No</th>
                                    <th style="width:30%;">Komponen</th>
                                    <th class="text-center" style="width:15%;">Centang yang sesuai</th>
                                    <th style="width:50%;" class="text-center"></th>
                                </tr>
                                {{-- <tr>
                                    <td class="text-center">1.A</td>
                                    <td>Kualitas Perencanaan (KKE 1.b)</td>
                                    <td class="text-center"><input type="radio" class="form-check-input"
                                            name="KategoriInovasi" wire:model.live.debounce.100ms='kategoriInovasi'
                                            value="perencanaan">
                                        @error('perencanaan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1" class="form-control"
                                            wire:model='keterangan_perencanaan' {{ $kategoriInovasi == 'perencanaan' ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_perencanaan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">1.B</td>
                                    <td>Pemanfaatan Perencanaan (KKE 1.c)</td>
                                    <td class="text-center"><input type="radio" class="form-check-input"
                                            name="KategoriInovasi" wire:model.live.debounce.100ms='kategoriInovasi'
                                            value="pemanfaatan_perencanaan">
                                        @error('pemanfaatan_perencanaan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" cols="30" rows="1" wire:model='keterangan_pemanfaatan_perencanaan'
                                            {{ $kategoriInovasi == 'pemanfaatan_perencanaan' ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_pemanfaatan_perencanaan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">2.A</td>
                                    <td>Kualitas Pengukuran Kinerja (KKE 2.b)</td>
                                    <td class="text-center"><input type="radio" class="form-check-input"
                                            name="KategoriInovasi" wire:model.live.debounce.100ms='kategoriInovasi'
                                            value="pengukuran">
                                        @error('pengukuran')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" cols="30" rows="1" wire:model='keterangan_pengukuran'
                                            {{ $kategoriInovasi == 'pengukuran' ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_pengukuran')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">2.B</td>
                                    <td>Pemanfaatan Pengukuran Kinerja (KKE 2.c)</td>
                                    <td class="text-center"><input type="radio" class="form-check-input"
                                            name="KategoriInovasi" wire:model.live.debounce.100ms='kategoriInovasi'
                                            value="pemanfaatan_pengukuran">
                                        @error('pemanfaatan_pengukuran')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" cols="30" rows="1" wire:model='keterangan_pemanfaatan_pengukuran'
                                            {{ $kategoriInovasi == 'pemanfaatan_pengukuran' ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_pemanfaatan_pengukuran')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">3.A</td>
                                    <td>Kualitas Pelaporan Kinerja (KKE 3.b) </td>
                                    <td class="text-center"><input type="radio" class="form-check-input"
                                            name="KategoriInovasi" wire:model.live.debounce.100ms='kategoriInovasi'
                                            value="pelaporan">
                                        @error('pelaporan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" cols="30" rows="1" wire:model='keterangan_pelaporan'
                                            {{ $kategoriInovasi == 'pelaporan' ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_pelaporan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">3.B</td>
                                    <td>Pemanfaatan Pelaporan Kinerja (KKE 3.c) </td>
                                    <td class="text-center"><input type="radio" class="form-check-input"
                                            name="KategoriInovasi" wire:model.live.debounce.100ms='kategoriInovasi'
                                            value="pemanfaatan_pelaporan">
                                        @error('pemanfaatan_pelaporan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" cols="30" rows="1" wire:model='keterangan_pemanfaatan_pelaporan'
                                            {{ $kategoriInovasi == 'pemanfaatan_pelaporan' ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_pemanfaatan_pelaporan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">4.A</td>
                                    <td>Kualitas Evaluasi Akuntabilitas Kinerja (KKE 4.b)</td>
                                    <td class="text-center"><input type="radio" class="form-check-input"
                                            name="KategoriInovasi" wire:model.live.debounce.100ms='kategoriInovasi'
                                            value="evaluasi_akuntabilitas">
                                        @error('evaluasi_akuntabilitas')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" cols="30" rows="1" wire:model='keterangan_evaluasi_akuntabilitas'
                                            {{ $kategoriInovasi == 'evaluasi_akuntabilitas' ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_evaluasi_akuntabilitas')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">4.B</td>
                                    <td>Pemanfaatan Evaluasi Akuntabilitas Kinerja (KKE 4.c)</td>
                                    <td class="text-center"><input type="radio" class="form-check-input"
                                            name="KategoriInovasi" wire:model.live.debounce.100ms='kategoriInovasi'
                                            value="pemanfaatan_evaluasi_akuntabilitas">
                                        @error('pemanfaatan_evaluasi_akuntabilitas')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" cols="30" rows="1"
                                            wire:model='keterangan_pemanfaatan_evaluasi_akuntabilitas'
                                            {{ $kategoriInovasi == 'pemanfaatan_evaluasi_akuntabilitas' ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_pemanfaatan_evaluasi_akuntabilitas')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr> --}}
                                <tr>
                                    <td class="text-center">1.A</td>
                                    <td>Kualitas Perencanaan (KKE 1.b)</td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='perencanaan'>
                                        @error('perencanaan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1" class="form-control"
                                            wire:model='keterangan_perencanaan' {{ $perencanaan ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_perencanaan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">1.B</td>
                                    <td>Pemanfaatan Perencanaan (KKE 1.c)</td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='pemanfaatan_perencanaan'>
                                        @error('pemanfaatan_perencanaan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" cols="30" rows="1" wire:model='keterangan_pemanfaatan_perencanaan'
                                            {{ $pemanfaatan_perencanaan ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_pemanfaatan_perencanaan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">2.A</td>
                                    <td>Kualitas Pengukuran Kinerja (KKE 2.b)</td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='pengukuran'>
                                        @error('pengukuran')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" cols="30" rows="1" wire:model='keterangan_pengukuran'
                                            {{ $pengukuran ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_pengukuran')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">2.B</td>
                                    <td>Pemanfaatan Pengukuran Kinerja (KKE 2.c)</td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='pemanfaatan_pengukuran'>
                                        @error('pemanfaatan_pengukuran')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" cols="30" rows="1" wire:model='keterangan_pemanfaatan_pengukuran'
                                            {{ $pemanfaatan_pengukuran ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_pemanfaatan_pengukuran')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">3.A</td>
                                    <td>Kualitas Pelaporan Kinerja (KKE 3.b) </td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='pelaporan'>
                                        @error('pelaporan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" cols="30" rows="1" wire:model='keterangan_pelaporan'
                                            {{ $pelaporan ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_pelaporan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">3.B</td>
                                    <td>Pemanfaatan Pelaporan Kinerja (KKE 3.c) </td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='pemanfaatan_pelaporan'>
                                        @error('pemanfaatan_pelaporan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" cols="30" rows="1" wire:model='keterangan_pemanfaatan_pelaporan'
                                            {{ $pemanfaatan_pelaporan ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_pemanfaatan_pelaporan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">4.A</td>
                                    <td>Kualitas Evaluasi Akuntabilitas Kinerja (KKE 4.b)</td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='evaluasi_akuntabilitas'>
                                        @error('evaluasi_akuntabilitas')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" cols="30" rows="1" wire:model='keterangan_evaluasi_akuntabilitas'
                                            {{ $evaluasi_akuntabilitas ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_evaluasi_akuntabilitas')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">4.B</td>
                                    <td>Pemanfaatan Evaluasi Akuntabilitas Kinerja (KKE 4.c)</td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='pemanfaatan_evaluasi_akuntabilitas'>
                                        @error('pemanfaatan_evaluasi_akuntabilitas')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" cols="30" rows="1"
                                            wire:model='keterangan_pemanfaatan_evaluasi_akuntabilitas'
                                            {{ $pemanfaatan_evaluasi_akuntabilitas ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_pemanfaatan_evaluasi_akuntabilitas')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="4">D. Waktu (Sesuai Periode Pelaksanaan Evaluasi dan Belum Pernah
                                        diusulkan pada tahun sebelumnya untuk dievaluasi (T-2))</th>
                                </tr>
                                <tr>
                                    <th class="text-center" style="width:5%;">No</th>
                                    <th style="width:30%;">Tahun Inovasi</th>
                                    <th class="text-center" style="width:15%;">Jumlah</th>
                                    <th style="width:50%;" class="text-center">Keterangan</th>
                                </tr>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td><input type="number" class="form-control form-control-sm" wire:model='tahun'
                                            step="1">
                                        @error('tahun')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td class="text-center"><input type="number" step="1"
                                            class="form-control form-control-sm" wire:model='jumlah_tahun'>
                                        @error('jumlah_tahun')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="4">E. Bukti Inovasi (Manual Book, SK, MoU, dll)</th>
                                </tr>
                                <tr>
                                    <th class="text-center" style="width:5%;">No</th>
                                    <th style="width:30%;">Rincian</th>
                                    <th class="text-center" style="width:15%;">Jumlah</th>
                                    <th style="width:50%;" class="text-center">Keterangan</th>
                                </tr>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>SK</td>
                                    <td class="text-center"><input type="number" step="1"
                                            class="form-control form-control-sm"
                                            wire:model.live.debounce.100ms='jumlah_sk'>
                                        @error('jumlah_sk')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" cols="30" rows="1" wire:model='keterangan_sk'
                                            {{ $jumlah_sk > 0 ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_sk')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td>Manual Book</td>
                                    <td class="text-center"><input type="number" step="1"
                                            class="form-control form-control-sm"
                                            wire:model.live.debounce.100ms='jumlah_manual_book'>
                                        @error('jumlah_manual_book')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" cols="30" rows="1" wire:model='keterangan_manual_book'
                                            {{ $jumlah_manual_book > 0 ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_manual_book')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">3</td>
                                    <td>Laporan Inovasi</td>
                                    <td class="text-center"><input type="number" step="1"
                                            class="form-control form-control-sm"
                                            wire:model.live.debounce.100ms='jumlah_laporan'>
                                        @error('jumlah_laporan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" cols="30" rows="1" wire:model='keterangan_laporan'
                                            {{ $jumlah_laporan > 0 ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_laporan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">4</td>
                                    <td>Tangkap Layar Aplikasi</td>
                                    <td class="text-center"><input type="number" step="1"
                                            class="form-control form-control-sm"
                                            wire:model.live.debounce.100ms='jumlah_tangkap_layar'>
                                        @error('jumlah_tangkap_layar')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" cols="30" rows="1" wire:model='keterangan_tangkap_layar'
                                            {{ $jumlah_tangkap_layar > 0 ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_tangkap_layar')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">5</td>
                                    <td>Matrik Before After</td>
                                    <td class="text-center"><input type="number" step="1"
                                            class="form-control form-control-sm"
                                            wire:model.live.debounce.100ms='jumlah_matrik'>
                                        @error('jumlah_matrik')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" cols="30" rows="1" wire:model='keterangan_matrik'
                                            {{ $jumlah_matrik > 0 ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_matrik')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">6</td>
                                    <td>Bukti lainnya</td>
                                    <td class="text-center"><input type="number" step="1"
                                            class="form-control form-control-sm"
                                            wire:model.live.debounce.100ms='jumlah_bukti_lainnya'>
                                        @error('jumlah_bukti_lainnya')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1" wire:model='keterangan_bukti_lainnya'
                                            {{ $jumlah_bukti_lainnya > 0 ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_bukti_lainnya')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="4">F. Dokumen Pendukung</th>
                                </tr>
                                <tr>
                                    <th class="text-center" style="width:5%;">No</th>
                                    <th style="width:30%;">Rincian</th>
                                    <th class="text-center" style="width:15%;">Jumlah</th>
                                    <th style="width:50%;" class="text-center">Keterangan</th>
                                </tr>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>HKI</td>
                                    <td class="text-center"><input type="number" step="1"
                                            class="form-control form-control-sm"
                                            wire:model.live.debounce.100ms='jumlah_hki'>
                                        @error('jumlah_hki')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1" wire:model='keterangan_hki'
                                            {{ $jumlah_hki > 0 ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_hki')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td>Paten</td>
                                    <td class="text-center"><input type="number" step="1"
                                            class="form-control form-control-sm"
                                            wire:model.live.debounce.100ms='jumlah_paten'>
                                        @error('jumlah_paten')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1" wire:model='keterangan_paten'
                                            {{ $jumlah_paten > 0 ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_paten')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">3</td>
                                    <td>Pengakuan dari Instansi Lain</td>
                                    <td class="text-center"><input type="number" step="1"
                                            class="form-control form-control-sm"
                                            wire:model.live.debounce.100ms='jumlah_pengakuan'>
                                        @error('jumlah_pengakuan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1" wire:model='keterangan_pengakuan'
                                            {{ $jumlah_pengakuan > 0 ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_pengakuan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">4</td>
                                    <td>Penghargaan Nasional / Regional / Internal</td>
                                    <td class="text-center"><input type="number" step="1"
                                            class="form-control form-control-sm"
                                            wire:model.live.debounce.100ms='jumlah_penghargaan'>
                                        @error('jumlah_penghargaan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1" wire:model='keterangan_penghargaan'
                                            {{ $jumlah_penghargaan > 0 ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_penghargaan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">5</td>
                                    <td>Dokumen lainnya</td>
                                    <td class="text-center"><input type="number" step="1"
                                            class="form-control form-control-sm"
                                            wire:model.live.debounce.100ms='jumlah_dokumen_lainnya'>
                                        @error('jumlah_dokumen_lainnya')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1" wire:model='keterangan_dokumen_lainnya'
                                            {{ $jumlah_dokumen_lainnya > 0 ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_dokumen_lainnya')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="4">G. Penilaian Inovasi</th>
                                </tr>
                                <tr>
                                    <th class="text-center" style="width:5%;">No</th>
                                    <th style="width:30%;">Kategori Penilaian</th>
                                    <th class="text-center" style="width:15%;">Cheklist</th>
                                    <th style="width:50%;" class="text-center">Keterangan</th>
                                </tr>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>Tidak ada (kriteria 1-8) Nilai 0</td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='tidak_inovasi'>
                                        @error('tidak_inovasi')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1" wire:model='keterangan_tidak_inovasi'
                                            {{ $tidak_inovasi ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_tidak_inovasi')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td>Dapat dihargai (kriteria 1-9) Nilai 0,5</td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='dihargai'>
                                        @error('dihargai')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1" wire:model='keterangan_dihargai'
                                            {{ $dihargai ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_dihargai')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                {{-- <tr>
                                    <td class="text-center">2</td>
                                    <td>Diadopsi Satker Lain (Kriteria 1 - 9)</td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model='diadopsi'>
                                        @error('diadopsi')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1" wire:model='keterangan_diadopsi'></textarea>
                                        @error('keterangan_diadopsi')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr> --}}
                                <tr>
                                    <td class="text-center">3</td>
                                    <td>Percontohan Nasional (kriteria 1-10) Nilai 1</td>
                                    <td class="text-center"><input type="checkbox" class="form-check-input"
                                            wire:model.live.debounce.100ms='penilaian_percontohan'>
                                        @error('penilaian_percontohan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <textarea class="form-control" id="" cols="30" rows="1"
                                            wire:model='keterangan_penilaian_percontohan' {{ $penilaian_percontohan ? '' : 'disabled' }}></textarea>
                                        @error('keterangan_penilaian_percontohan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="4">KESIMPULAN</td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <textarea class="form-control" id="" cols="30" rows="3" wire:model='kesimpulan'></textarea>
                                        @error('kesimpulan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"> Anggota SPI </td>
                                    <td colspan="2">
                                        <div class="input-group">
                                            <input type="text" name="" id="modalAtasan"
                                                class="form-control" wire:model.live.debounce.300ms='cariSPI'
                                                placeholder="Ketikkan Nama Anggota SPI">
                                            <span class="input-group-text" id="basic-addon1"><i
                                                    class="ti ti-user"></i></span>
                                            <select class="form-select form-select-sm" wire:model='spi'>
                                                <option value="">-- Pilih Anggota SPI --</option>
                                                @foreach ($dataUser1 as $du)
                                                    <option value="{{ $du->id }}">{{ $du->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('spi')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">Kepala SPI </td>
                                    <td colspan="2">
                                        <div class="input-group">
                                            <input type="text" name="" id="modalAtasan"
                                                class="form-control" wire:model.live.debounce.300ms='cariKepalaSPI'
                                                placeholder="Ketikkan Nama Kepala SPI">
                                            <span class="input-group-text" id="basic-addon1"><i
                                                    class="ti ti-user"></i></span>
                                            <select class="form-select form-select-sm" wire:model='kepala_spi'>
                                                <option value="">-- Pilih Kepala SPI --</option>
                                                @foreach ($dataUser2 as $du)
                                                    <option value="{{ $du->id }}">{{ $du->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('kepala_spi')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">PPE 1</td>
                                    <td colspan="2">
                                        <div class="input-group">
                                            <input type="text" name="" id="modalAtasan"
                                                class="form-control" wire:model.live.debounce.300ms='cariPPE'
                                                placeholder="Ketikkan Nama PPE 1">
                                            <span class="input-group-text" id="basic-addon1"><i
                                                    class="ti ti-user"></i></span>
                                            <select class="form-select form-select-sm" wire:model='ppe_1'>
                                                <option value="">-- Pilih PPE 1 --</option>
                                                @foreach ($dataUser3 as $du)
                                                    <option value="{{ $du->id }}">{{ $du->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('ppe_1')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">PPE 2</td>
                                    <td colspan="2">
                                        <div class="input-group">
                                            <input type="text" name="" id="modalAtasan"
                                                class="form-control" wire:model.live.debounce.300ms='cariPPE2'
                                                placeholder="Ketikkan Nama PPE 2">
                                            <span class="input-group-text" id="basic-addon1"><i
                                                    class="ti ti-user"></i></span>
                                            <select class="form-select form-select-sm" wire:model='ppe_2'>
                                                <option value="">-- Pilih PPE 2 --</option>
                                                @foreach ($dataUser4 as $du)
                                                    <option value="{{ $du->id }}">{{ $du->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('ppe_1')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>
                            </table>

                            <button type="button" class="btn btn-secondary btn-sm"
                                wire:click='tutupForm'>Tutup</button>
                            <button type="submit" class="btn btn-primary btn-sm"
                                @cannot('Inovasi-Operator-Create', $detailInovasi) disabled @endcannot>
                                Simpan
                            </button>
                            @if (session()->has('success'))
                                <label for="success" class="fst-italic ms-5">{{ session('success') }}</label>
                            @endif
                            @if (session()->has('error'))
                                <label for="success"
                                    class="text-danger fst-italic ms-5">{{ session('error') }}</label>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <div class="float-start">
                <form class="row g-3">
                    <div class="col-auto ">
                        <label for="periode" class="text align-middle mt-1">Pencarian</label>
                    </div>
                    <div class="col-auto">
                        <input type="text" class="form-control form-control-sm"
                            wire:model.live.debounce.500ms="cariNamaInovasi" placeholder="Cari Nama Inovasi"
                            id="inputCariNamaInovasi">
                    </div>
                    <div class="col-auto">
                        <input type="text" class="form-control form-control-sm"
                            wire:model.live.debounce.500ms="cariPengusul" placeholder="Cari Pengusul"
                            id="inputCariPengusul">
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="resetCari">Reset</button>
                    </div>
                </form>
            </div>

            <div class="float-end">
                <div class="row g-3">
                    <div class="col-auto ">
                        <label for="selectPeriode" class="text align-middle mt-1">Periode</label>
                    </div>
                    <div class="col-auto">
                        <select class="form-control form-control-sm pe-5" id="selectPeriode"
                            wire:model.live.debounce.500ms='selectedPeriode'>
                            @foreach ($periode as $p)
                                <option value="{{ $p->tahun }}"
                                    {{ $selectedPeriode == $p->tahun ? 'selected' : '' }}>
                                    {{ $p->tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover table-sm" id="example">
                    <thead class="align-middle text-center">
                        <tr>
                            <th style="width: 15%;">Nama Inovasi</th>
                            <th style="width: 10%;">Pengusul</th>
                            <th style="width: 40%;">Deskripsi</th>
                            <th style="width: 10%;">Periode</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $a)
                            <tr wire:key="data_inovasi_{{ $a->id }}">
                                <td>{{ $a->judul }}</td>
                                <td> {{ $a->pengusul->name }} </td>
                                <td> {{ $a->deskripsi }} </td>
                                <td class="text-center">
                                    {{ $a->periode->tahun }}</td>

                                <td class="text-center">
                                    @if ($a->status == 'ditolak')
                                        <span class="badge rounded-pill text-bg-danger">{{ $a->status }}</span>
                                    @elseif($a->status == 'diterima')
                                        <span class="badge rounded-pill text-bg-success">{{ $a->status }}</span>
                                    @elseif($a->status == 'diajukan')
                                        <span class="badge rounded-pill text-bg-primary">{{ $a->status }}</span>
                                    @elseif($a->status == 'draft')
                                        <span class="badge rounded-pill text-bg-secondary">{{ $a->status }}</span>
                                    @elseif($a->status == 'dijadwalkan')
                                        <span class="badge rounded-pill text-bg-info">{{ $a->status }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-success btn-sm" data-toggle="tooltip"
                                            data-placement="bottom" title="Checklist Berita Acara"
                                            wire:click='tampilBA({{ $a->id }})'>
                                            <i class="ti ti-file-check align-middle"></i></button>
                                        <button
                                            class="btn btn-primary btn-sm {{ $a->beritaAcara ? '' : 'disabled' }}"
                                            data-toggle="tooltip" data-placement="bottom"
                                            title="Download Berita Acara"
                                            wire:click='print({{ $a->beritaAcara ? $a->beritaAcara->id : '' }})'>
                                            <i class="ti ti-file-download align-middle"></i></button>
                                        <a href="{{ route('inovasi.print.berita.acara', $a->id) }}" target="_blank"
                                            class="btn btn-info btn-sm {{ $a->beritaAcara ? '' : 'disabled' }}"
                                            data-toggle="tooltip" data-placement="bottom" title="Cetak Berita Acara">
                                            <i class="ti ti-printer align-middle"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $data->links() }}
                </div>
            </div>

        </div>
    </div>
</div>
