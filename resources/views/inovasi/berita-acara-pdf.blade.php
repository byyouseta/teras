<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ public_path('mantis/assets/images/favicon.svg') }}" type="image/x-icon">
    <title>Berita Acara Verifikasi Inovasi</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            margin: 25px;
        }

        h3,
        h4 {
            text-align: center;
            margin: 5px 0;
        }

        .section-title {
            font-weight: bold;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: top;
        }

        th {
            text-align: center;
        }

        .no-border td {
            border: none !important;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .mt-3 {
            margin-top: 15px;
        }

        .checkmark {
            font-size: 20px;
            vertical-align: top;
            color: #000;
        }

        .no-break {
            page-break-inside: avoid;
        }
    </style>

</head>

<body>
    @foreach ($dataLaporan as $index => $laporan)
        @if ($index > 0)
            <div style="page-break-before: always;"></div>
        @endif

        <h3>BERITA ACARA VERIFIKASI INOVASI IMPLEMENTASI SAKIP RSUP SURAKARTA</h3>

        <p style="text-align: center; font-size: 12px;">Berdasarkan Pembahasan Hasil Verifikasi Inovasi Implementasi
            SAKIP
            pada Rumah Sakit
            Umum
            Pusat Surakarta, maka
            diperoleh hasil sebagai berikut :</p>
        <table style=" border-collapse: collapse; border: none; width:100%;">
            <tr>
                <td style="width: 35%; padding-left:40px;border: none; ">Nama Inovasi</td>
                <td style="width: 65%;border: none; ">: {{ $laporan['data']->inovasi->judul }}</td>
            </tr>
        </table>

        <div class="no-break">
            <div class="section-title">A. JENIS INOVASI</div>
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 35%">Rincian</th>
                        <th style="width: 10%">Centang</th>
                        <th style="width: 50%">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">1</td>
                        <td>Kebijakan</td>
                        <td class="text-center checkmark">{!! $laporan['data']->kebijakan ? '&#10004;' : '' !!}</td>
                        <td>{{ $laporan['data']->keterangan_kebijakan ? $laporan['data']->keterangan_kebijakan : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">2</td>
                        <td>Teknologi Kesehatan</td>
                        <td class="text-center checkmark">{!! $laporan['data']->tek_kes ? '&#10004;' : '' !!}</td>
                        <td>{{ $laporan['data']->keterangan_tek_kes ? $laporan['data']->keterangan_tek_kes : '' }}</td>
                    </tr>
                    <tr>
                        <td class="text-center ">3</td>
                        <td>Teknologi Sistem Informasi</td>
                        <td class="text-center checkmark">
                            {!! $laporan['data']->tek_si ? '&#10004;' : '' !!}
                        </td>
                        <td>
                            {{ $laporan['data']->keterangan_tek_si ? $laporan['data']->keterangan_tek_si : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">4</td>
                        <td>Pelayanan Publik</td>
                        <td class="text-center checkmark">{!! $laporan['data']->pelayanan_publik ? '&#10004;' : '' !!}</td>
                        <td>{{ $laporan['data']->keterangan_pelayanan_publik ? $laporan['data']->keterangan_pelayanan_publik : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">5</td>
                        <td>Budaya Kerja</td>
                        <td class="text-center checkmark">{!! $laporan['data']->budaya_kerja ? '&#10004;' : '' !!}</td>
                        <td>{{ $laporan['data']->keterangan_budaya_kerja ? $laporan['data']->keterangan_budaya_kerja : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">6</td>
                        <td>Metode Kerja / SOP</td>
                        <td class="text-center checkmark">{!! $laporan['data']->sop ? '&#10004;' : '' !!}</td>
                        <td>{{ $laporan['data']->keterangan_sop ? $laporan['data']->keterangan_sop : '' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="no-break">
            <div class="section-title">B. KRITERIA INOVASI</div>
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 35%">Rincian</th>
                        <th style="width: 10%">Centang</th>
                        <th style="width: 50%">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">1</td>
                        <td>Pembaharuan / Orisinal / Modifikasi</td>
                        <td class="text-center checkmark">{!! $laporan['data']->pembaharuan ? '&#10004;' : '' !!}</td>
                        <td>{{ $laporan['data']->keterangan_pembaharuan ? $laporan['data']->keterangan_pembaharuan : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">2</td>
                        <td>Memudahkan Pelayanan</td>
                        <td class="text-center checkmark">{!! $laporan['data']->memudahkan ? '&#10004;' : '' !!}</td>
                        <td>{{ $laporan['data']->keterangan_memudahkan ? $laporan['data']->keterangan_memudahkan : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">3</td>
                        <td>Mempercepat Pelayanan</td>
                        <td class="text-center checkmark">{!! $laporan['data']->mempercepat ? '&#10004;' : '' !!}</td>
                        <td>{{ $laporan['data']->keterangan_mempercepat ? $laporan['data']->keterangan_mempercepat : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">4</td>
                        <td>Disebarluaskan</td>
                        <td class="text-center checkmark">{!! $laporan['data']->disebarluaskan ? '&#10004;' : '' !!}</td>
                        <td>{{ $laporan['data']->keterangan_disebarluaskan ? $laporan['data']->keterangan_disebarluaskan : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">5</td>
                        <td>Bermanfaat</td>
                        <td class="text-center checkmark">{!! $laporan['data']->bermanfaat ? '&#10004;' : '' !!}</td>
                        <td>{{ $laporan['data']->keterangan_bermanfaat ? $laporan['data']->keterangan_bermanfaat : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">6</td>
                        <td>Spesifik</td>
                        <td class="text-center checkmark">{!! $laporan['data']->spesifik ? '&#10004;' : '' !!}</td>
                        <td>{{ $laporan['data']->keterangan_spesifik ? $laporan['data']->keterangan_spesifik : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">7</td>
                        <td>Berkelanjutan</td>
                        <td class="text-center checkmark">{!! $laporan['data']->berkelanjutan ? '&#10004;' : '' !!}</td>
                        <td>{{ $laporan['data']->keterangan_berkelanjutan ? $laporan['data']->keterangan_berkelanjutan : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">8</td>
                        <td>Solusi / Upaya pemecahan masalah</td>
                        <td class="text-center checkmark">{!! $laporan['data']->solusi ? '&#10004;' : '' !!}</td>
                        <td>{{ $laporan['data']->keterangan_solusi ? $laporan['data']->keterangan_solusi : '' }}</td>
                    </tr>
                    <tr>
                        <td class="text-center">9</td>
                        <td>Dapat diaplikasikan di Internal / Eksternal</td>
                        <td class="text-center checkmark">{!! $laporan['data']->dapat_diaplikasikan ? '&#10004;' : '' !!}</td>
                        <td>{{ $laporan['data']->keterangan_dapat_diaplikasikan ? $laporan['data']->keterangan_dapat_diaplikasikan : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">10</td>
                        <td>Percontohan Nasional</td>
                        <td class="text-center checkmark">{!! $laporan['data']->percontohan ? '&#10004;' : '' !!}</td>
                        <td>{{ $laporan['data']->keterangan_percontohan ? $laporan['data']->keterangan_percontohan : '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="no-break">
            <div class="section-title">C. KATEGORI INOVASI DALAM IMPLEMENTASI SAKIP</div>
            <table>
                <thead>
                    <tr>
                        <th style="width:5%">No</th>
                        <th style="width:35%">Komponen</th>
                        <th style="width:10%">Checklist</th>
                        <th style="width: 50%">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">1.A</td>
                        <td>Kualitas Perencanaan (KKE 1.b)</td>
                        <td class="text-center checkmark">{!! $laporan['key'] == 'perencanaan' ? '&#10004;' : '' !!}</td>
                        <td>{{ $laporan['key'] == 'perencanaan' && $laporan['data']->keterangan_perencanaan ? $laporan['data']->keterangan_perencanaan : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">1.B</td>
                        <td>Pemanfaatan Perencanaan (KKE 1.c)</td>
                        <td class="text-center checkmark">{!! $laporan['key'] == 'pemanfaatan_perencanaan' ? '&#10004;' : '' !!}</td>
                        <td>{{ $laporan['key'] == 'pemanfaatan_perencanaan' && $laporan['data']->keterangan_pemanfaatan_perencanaan ? $laporan['data']->keterangan_pemanfaatan_perencanaan : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">2.A</td>
                        <td>Kualitas Pengukuran Kinerja (KKE 2.b)</td>
                        <td class="text-center checkmark">{!! $laporan['key'] == 'pengukuran' ? '&#10004;' : '' !!}</td>
                        <td>{{ $laporan['key'] == 'pengukuran' && $laporan['data']->keterangan_pengukuran ? $laporan['data']->keterangan_pengukuran : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">2.B</td>
                        <td>Pemanfaatan Pengukuran Kinerja (KKE 2.c)</td>
                        <td class="text-center checkmark">{!! $laporan['key'] == 'pemanfaatan_pengukuran' ? '&#10004;' : '' !!}</td>
                        <td>{{ $laporan['key'] == 'pemanfaatan_pengukuran' && $laporan['data']->keterangan_pemanfaatan_pengukuran ? $laporan['data']->keterangan_pemanfaatan_pengukuran : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">3.A</td>
                        <td>Kualitas Pelaporan Kinerja (KKE 3.b)</td>
                        <td class="text-center checkmark">{!! $laporan['key'] == 'pelaporan' ? '&#10004;' : '' !!}</td>
                        <td>{{ $laporan['key'] == 'pelaporan' && $laporan['data']->keterangan_pelaporan ? $laporan['data']->keterangan_pelaporan : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">3.B</td>
                        <td>Pemanfaatan Pelaporan Kinerja (KKE 3.c)</td>
                        <td class="text-center checkmark">{!! $laporan['key'] == 'pemanfaatan_pelaporan' ? '&#10004;' : '' !!}</td>
                        <td>{{ $laporan['key'] == 'pemanfaatan_pelaporan' && $laporan['data']->keterangan_pemanfaatan_pelaporan ? $laporan['data']->keterangan_pemanfaatan_pelaporan : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">4.A</td>
                        <td>Kualitas Evaluasi Akuntabilitas Kinerja (KKE 4.b)</td>
                        <td class="text-center checkmark">{!! $laporan['key'] == 'evaluasi_akuntabilitas' ? '&#10004;' : '' !!}</td>
                        <td>{{ $laporan['key'] == 'evaluasi_akuntabilitas' && $laporan['data']->keterangan_evaluasi_akuntabilitas ? $laporan['data']->keterangan_evaluasi_akuntabilitas : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">4.B</td>
                        <td>Pemanfaatan Evaluasi Akuntabilitas Kinerja (KKE 4.c)</td>
                        <td class="text-center checkmark">{!! $laporan['key'] == 'pemanfaatan_evaluasi_akuntabilitas' ? '&#10004;' : '' !!}</td>
                        <td>{{ $laporan['key'] == 'pemanfaatan_evaluasi_akuntabilitas' && $laporan['data']->keterangan_pemanfaatan_evaluasi_akuntabilitas ? $laporan['data']->keterangan_pemanfaatan_evaluasi_akuntabilitas : '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="no-break">
            <div class="section-title">D. WAKTU</div>
            <p>(Sesuai Periode Pelaksanaan Evaluasi dan Belum Pernah diusulkan pada tahun sebelumnya untuk dievaluasi
                T-2)
            </p>
            <table style="width: 100%">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 35%">Tahun Inovasi</th>
                        <th style="width: 10%">Jumlah</th>
                        <th style="width: 50%">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">1</td>
                        <td>{{ $laporan['data']->tahun ? $laporan['data']->tahun : '' }}</td>
                        <td class="text-center">
                            {{ $laporan['data']->jumlah_tahun ? $laporan['data']->jumlah_tahun : '' }}</td>
                        <td>{{ $laporan['data']->keterangan_tahun ? $laporan['data']->keterangan_tahun : '' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="no-break">
            <div class="section-title">E. BUKTI INOVASI (Manual Book, SK, MoU, dll)</div>
            <table style="width: 100%">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 35%">Rincian</th>
                        <th style="width: 10%">Jumlah</th>
                        <th style="width: 50%">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">1</td>
                        <td>SK</td>
                        <td class="text-center">{{ $laporan['data']->jumlah_sk ? $laporan['data']->jumlah_sk : '' }}
                        </td>
                        <td>{{ $laporan['data']->keterangan_sk ? $laporan['data']->keterangan_sk : '' }}</td>
                    </tr>
                    <tr>
                        <td class="text-center">2</td>
                        <td>Manual Book</td>
                        <td class="text-center">
                            {{ $laporan['data']->jumlah_manual_book ? $laporan['data']->jumlah_manual_book : '' }}</td>
                        <td>{{ $laporan['data']->keterangan_manual_book ? $laporan['data']->keterangan_manual_book : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">3</td>
                        <td>Laporan Inovasi</td>
                        <td class="text-center">
                            {{ $laporan['data']->jumlah_laporan ? $laporan['data']->jumlah_laporan : '' }}</td>
                        <td>{{ $laporan['data']->keterangan_laporan ? $laporan['data']->keterangan_laporan : '' }}</td>
                    </tr>
                    <tr>
                        <td class="text-center">4</td>
                        <td>Tangkap Layar Aplikasi</td>
                        <td class="text-center">
                            {{ $laporan['data']->jumlah_tangkap_layar ? $laporan['data']->jumlah_tangkap_layar : '' }}
                        </td>
                        <td>{{ $laporan['data']->keterangan_tangkap_layar ? $laporan['data']->keterangan_tangkap_layar : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">5</td>
                        <td>Matrik Before After</td>
                        <td class="text-center">
                            {{ $laporan['data']->jumlah_matrik ? $laporan['data']->jumlah_matrik : '' }}</td>
                        <td>{{ $laporan['data']->keterangan_matrik ? $laporan['data']->keterangan_matrik : '' }}</td>
                    </tr>
                    <tr>
                        <td class="text-center">6</td>
                        <td>Bukti lainnya</td>
                        <td class="text-center">
                            {{ $laporan['data']->jumlah_bukti_lainnya ? $laporan['data']->jumlah_bukti_lainnya : '' }}
                        </td>
                        <td>{{ $laporan['data']->keterangan_bukti_lainnya ? $laporan['data']->keterangan_bukti_lainnya : '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="no-break">
            <div class="section-title">F. DOKUMEN PENDUKUNG</div>
            <table style="width: 100%">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 35%">Rincian</th>
                        <th style="width: 10%">Jumlah</th>
                        <th style="width: 50%">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">1</td>
                        <td>HKI</td>
                        <td class="text-center">{{ $laporan['data']->jumlah_hki ? $laporan['data']->jumlah_hki : '' }}
                        </td>
                        <td>{{ $laporan['data']->keterangan_hki ? $laporan['data']->keterangan_hki : '' }}</td>
                    </tr>
                    <tr>
                        <td class="text-center">2</td>
                        <td>Paten</td>
                        <td class="text-center">
                            {{ $laporan['data']->jumlah_paten ? $laporan['data']->jumlah_paten : '' }}</td>
                        <td>{{ $laporan['data']->keterangan_paten ? $laporan['data']->keterangan_paten : '' }}</td>
                    </tr>
                    <tr>
                        <td class="text-center">3</td>
                        <td>Pengakuan dari Instansi Lain </td>
                        <td class="text-center">
                            {{ $laporan['data']->jumlah_pengakuan ? $laporan['data']->jumlah_pengakuan : '' }}</td>
                        <td>{{ $laporan['data']->keterangan_pengakuan ? $laporan['data']->keterangan_pengakuan : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">4</td>
                        <td>Penghargaan Nasional / Regional / Internal</td>
                        <td class="text-center">
                            {{ $laporan['data']->jumlah_penghargaan ? $laporan['data']->jumlah_penghargaan : '' }}</td>
                        <td>{{ $laporan['data']->keterangan_penghargaan ? $laporan['data']->keterangan_penghargaan : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">5</td>
                        <td>Dokumen lainnya</td>
                        <td class="text-center">
                            {{ $laporan['data']->jumlah_dokumen_lainnya ? $laporan['data']->jumlah_dokumen_lainnya : '' }}
                        </td>
                        <td>{{ $laporan['data']->keterangan_dokumen_lainnya ? $laporan['data']->keterangan_dokumen_lainnya : '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="no-break">
            <div class="section-title">G. PENILAIAN INOVASI</div>
            <table style="width:100%;">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 35%">Kategori Penilaian</th>
                        <th style="width: 10%">Checklist</th>
                        <th style="width: 50%">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">1</td>
                        <td>Tidak ada (kriteria 1-8) Nilai 0</td>
                        <td class="text-center checkmark">{!! $laporan['data']->tidak_inovasi ? '&#10004;' : '' !!}</td>
                        <td>{{ $laporan['data']->keterangan_tidak_inovasi ? $laporan['data']->keterangan_tidak_inovasi : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">2</td>
                        <td>Dapat dihargai (kriteria 1-9) Nilai 0,5</td>
                        <td class="text-center checkmark">{!! $laporan['data']->dihargai ? '&#10004;' : '' !!}</td>
                        <td>{{ $laporan['data']->keterangan_dihargai ? $laporan['data']->keterangan_dihargai : '' }}
                        </td>
                    </tr>
                    {{-- <tr>
                    <td class="text-center">2</td>
                    <td>Diadopsi Satker Lain (Kriteria 1 - 9)</td>
                    <td class="text-center checkmark">{!! $laporan['data']->diadopsi ? '&#10004;' : '' !!}</td>
                    <td>{{ $laporan['data']->keterangan_diadopsi ? $laporan['data']->keterangan_diadopsi : '' }}</td>
                </tr> --}}
                    <tr>
                        <td class="text-center">3</td>
                        <td>Percontohan Nasional (kriteria 1-10) Nilai 1</td>
                        <td class="text-center checkmark">{!! $laporan['data']->penilaian_percontohan ? '&#10004;' : '' !!}</td>
                        <td>{{ $laporan['data']->keterangan_penilaian_percontohan ? $laporan['data']->keterangan_penilaian_percontohan : '' }}
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <div class="no-break">
            <div class="section-title">KESIMPULAN</div>
            <p style="text-align: justify;">{{ $laporan['data']->kesimpulan ? $laporan['data']->kesimpulan : '' }}</p>
        </div>

        <div class="no-break">
            <table class="no-border" style="margin-top: 30px;">
                <tr>
                    <td class="text-center">
                    </td>
                    <td class="text-center">
                        <p>Surakarta,
                            {{ \Carbon\Carbon::parse($laporan['data']->tanggal_ba)->locale('id')->translatedFormat('d F Y') }}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">
                        <strong>Satuan Pemeriksaan Internal</strong><br><br><br><br><br>
                        <u>{{ $laporan['data']->spi ? $laporan['data']->anggotaSPI->name : '' }}</u>
                    </td>
                    <td class="text-center">
                        <strong>Petugas Tim Kerja PPE</strong><br><br><br><br><br>
                        <u>{{ $laporan['data']->ppe_1 ? $laporan['data']->petugasPPE1->name : '' }}</u>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">
                        <strong>Kepala SPI,</strong><br><br><br><br><br>
                        <u>{{ $laporan['data']->kepala_spi ? $laporan['data']->kepalaSPI->name : '' }}</u>
                    </td>
                    <td class="text-center">
                        <br><br><br><br><br>
                        <u>{{ $laporan['data']->ppe_2 ? $laporan['data']->petugasPPE2->name : '' }}</u>
                    </td>
                </tr>
            </table>
        </div>
    @endforeach
</body>

</html>
