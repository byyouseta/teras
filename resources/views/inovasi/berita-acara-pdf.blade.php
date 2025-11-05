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
    <h3>BERITA ACARA VERIFIKASI INOVASI IMPLEMENTASI SAKIP RSUP SURAKARTA</h3>

    <p style="text-align: center; font-size: 12px;">Berdasarkan Pembahasan Hasil Verifikasi Inovasi Implementasi SAKIP
        pada Rumah Sakit
        Umum
        Pusat Surakarta, maka
        diperoleh hasil sebagai berikut :</p>
    <table style=" border-collapse: collapse; border: none; width:100%;">
        <tr>
            <td style="width: 35%; padding-left:40px;border: none; ">Nama Inovasi</td>
            <td style="width: 65%;border: none; ">: {{ $data->inovasi->judul }}</td>
        </tr>
    </table>

    <div class="no-break">
        <div class="section-title">A. JENIS INOVASI</div>
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 30%">Rincian</th>
                    <th style="width: 15%">Centang</th>
                    <th style="width: 50%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td>Kebijakan</td>
                    <td class="text-center checkmark">{!! $data->kebijakan ? '&#10004;' : '' !!}</td>
                    <td>{{ $data->keterangan_kebijakan ? $data->keterangan_kebijakan : '' }}</td>
                </tr>
                <tr>
                    <td class="text-center">2</td>
                    <td>Teknologi Kesehatan</td>
                    <td class="text-center checkmark">{!! $data->tek_kes ? '&#10004;' : '' !!}</td>
                    <td>{{ $data->keterangan_tek_kes ? $data->keterangan_tek_kes : '' }}</td>
                </tr>
                <tr>
                    <td class="text-center ">3</td>
                    <td>Teknologi Sistem Informasi</td>
                    <td class="text-center checkmark">
                        {!! $data->tek_si ? '&#10004;' : '' !!}
                    </td>
                    <td>
                        {{ $data->keterangan_tek_si ? $data->keterangan_tek_si : '' }}
                    </td>
                </tr>
                <tr>
                    <td class="text-center">4</td>
                    <td>Pelayanan Publik</td>
                    <td class="text-center checkmark">{!! $data->pelayanan_publik ? '&#10004;' : '' !!}</td>
                    <td>{{ $data->keterangan_pelayanan_publik ? $data->keterangan_pelayanan_publik : '' }}</td>
                </tr>
                <tr>
                    <td class="text-center">5</td>
                    <td>Budaya Kerja</td>
                    <td class="text-center checkmark">{!! $data->budaya_kerja ? '&#10004;' : '' !!}</td>
                    <td>{{ $data->keterangan_budaya_kerja ? $data->keterangan_budaya_kerja : '' }}</td>
                </tr>
                <tr>
                    <td class="text-center">6</td>
                    <td>Metode Kerja / SOP</td>
                    <td class="text-center checkmark">{!! $data->sop ? '&#10004;' : '' !!}</td>
                    <td>{{ $data->keterangan_sop ? $data->keterangan_sop : '' }}</td>
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
                    <th style="width: 30%">Rincian</th>
                    <th style="width: 15%">Centang</th>
                    <th style="width: 50%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td>Pembaharuan / Orisinal / Modifikasi</td>
                    <td class="text-center checkmark">{!! $data->pembaharuan ? '&#10004;' : '' !!}</td>
                    <td>{{ $data->keterangan_pembaharuan ? $data->keterangan_pembaharuan : '' }}</td>
                </tr>
                <tr>
                    <td class="text-center">2</td>
                    <td>Memudahkan Pelayanan</td>
                    <td class="text-center checkmark">{!! $data->memudahkan ? '&#10004;' : '' !!}</td>
                    <td>{{ $data->keterangan_memudahkan ? $data->keterangan_memudahkan : '' }}</td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td>Mempercepat Pelayanan</td>
                    <td class="text-center checkmark">{!! $data->mempercepat ? '&#10004;' : '' !!}</td>
                    <td>{{ $data->keterangan_mempercepat ? $data->keterangan_mempercepat : '' }}</td>
                </tr>
                <tr>
                    <td class="text-center">4</td>
                    <td>Disebarluaskan</td>
                    <td class="text-center checkmark">{!! $data->disebarluaskan ? '&#10004;' : '' !!}</td>
                    <td>{{ $data->keterangan_disebarluaskan ? $data->keterangan_disebarluaskan : '' }}</td>
                </tr>
                <tr>
                    <td class="text-center">5</td>
                    <td>Bermanfaat</td>
                    <td class="text-center checkmark">{!! $data->bermanfaat ? '&#10004;' : '' !!}</td>
                    <td>{{ $data->keterangan_bermanfaat ? $data->keterangan_bermanfaat : '' }}</td>
                </tr>
                <tr>
                    <td class="text-center">6</td>
                    <td>Spesifik</td>
                    <td class="text-center checkmark">{!! $data->spesifik ? '&#10004;' : '' !!}</td>
                    <td>{{ $data->keterangan_spesifik ? $data->keterangan_spesifik : '' }}</td>
                </tr>
                <tr>
                    <td class="text-center">7</td>
                    <td>Berkelanjutan</td>
                    <td class="text-center checkmark">{!! $data->berkelanjutan ? '&#10004;' : '' !!}</td>
                    <td>{{ $data->keterangan_berkelanjutan ? $data->keterangan_berkelanjutan : '' }}</td>
                </tr>
                <tr>
                    <td class="text-center">8</td>
                    <td>Solusi / Upaya pemecahan masalah</td>
                    <td class="text-center checkmark">{!! $data->solusi ? '&#10004;' : '' !!}</td>
                    <td>{{ $data->keterangan_solusi ? $data->keterangan_solusi : '' }}</td>
                </tr>
                <tr>
                    <td class="text-center">9</td>
                    <td>Dapat diaplikasikan di Internal / Eksternal</td>
                    <td class="text-center checkmark">{!! $data->dapat_diaplikasikan ? '&#10004;' : '' !!}</td>
                    <td>{{ $data->keterangan_dapat_diaplikasikan ? $data->keterangan_dapat_diaplikasikan : '' }}</td>
                </tr>
                <tr>
                    <td class="text-center">10</td>
                    <td>Percontohan Nasional</td>
                    <td class="text-center checkmark">{!! $data->percontohan ? '&#10004;' : '' !!}</td>
                    <td>{{ $data->keterangan_percontohan ? $data->keterangan_percontohan : '' }}</td>
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
                    <th style="width:80%">Komponen</th>
                    <th style="width:15%">Checklist</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td>Perencanaan Kinerja</td>
                    <td class="text-center checkmark">{!! $data->perencanaan ? '&#10004;' : '' !!}</td>
                </tr>
                <tr>
                    <td class="text-center">2</td>
                    <td>Pengukuran Kinerja</td>
                    <td class="text-center checkmark">{!! $data->pengukuran ? '&#10004;' : '' !!}</td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td>Pelaporan Kinerja</td>
                    <td class="text-center checkmark">{!! $data->pelaporan ? '&#10004;' : '' !!}</td>
                </tr>
                <tr>
                    <td class="text-center">4</td>
                    <td>Evaluasi Akuntabilitas Internal</td>
                    <td class="text-center checkmark">{!! $data->evaluasi_akuntabilitas ? '&#10004;' : '' !!}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="no-break">
        <div class="section-title">D. WAKTU</div>
        <p>(Sesuai Periode Pelaksanaan Evaluasi dan Belum Pernah diusulkan pada tahun sebelumnya untuk dievaluasi T-2)
        </p>
        <table style="width: 100%">
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 30%">Tahun Inovasi</th>
                    <th style="width: 15%">Jumlah</th>
                    <th style="width: 50%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td>{{ $data->tahun ? $data->tahun : '' }}</td>
                    <td class="text-center">{{ $data->jumlah_tahun ? $data->jumlah_tahun : '' }}</td>
                    <td>{{ $data->keterangan_tahun ? $data->keterangan_tahun : '' }}</td>
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
                    <th style="width: 30%">Rincian</th>
                    <th style="width: 15%">Jumlah</th>
                    <th style="width: 50%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td>SK</td>
                    <td class="text-center">{{ $data->jumlah_sk ? $data->jumlah_sk : '' }}</td>
                    <td>{{ $data->keterangan_sk ? $data->keterangan_sk : '' }}</td>
                </tr>
                <tr>
                    <td class="text-center">2</td>
                    <td>Manual Book</td>
                    <td class="text-center">{{ $data->jumlah_manual_book ? $data->jumlah_manual_book : '' }}</td>
                    <td>{{ $data->keterangan_manual_book ? $data->keterangan_manual_book : '' }}</td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td>Laporan Inovasi</td>
                    <td class="text-center">{{ $data->jumlah_laporan ? $data->jumlah_laporan : '' }}</td>
                    <td>{{ $data->keterangan_laporan ? $data->keterangan_laporan : '' }}</td>
                </tr>
                <tr>
                    <td class="text-center">4</td>
                    <td>Tangkap Layar Aplikasi</td>
                    <td class="text-center">{{ $data->jumlah_tangkap_layar ? $data->jumlah_tangkap_layar : '' }}</td>
                    <td>{{ $data->keterangan_tangkap_layar ? $data->keterangan_tangkap_layar : '' }}</td>
                </tr>
                <tr>
                    <td class="text-center">5</td>
                    <td>Matrik Before After</td>
                    <td class="text-center">
                        {{ $data->jumlah_matrik_before_after ? $data->jumlah_matrik_before_after : '' }}</td>
                    <td>{{ $data->keterangan_matrik_before_after ? $data->keterangan_matrik_before_after : '' }}</td>
                </tr>
                <tr>
                    <td class="text-center">6</td>
                    <td>Bukti lainnya</td>
                    <td class="text-center">
                        {{ $data->jumlah_bukti_lainnya ? $data->jumlah_bukti_lainnya : '' }}</td>
                    <td>{{ $data->keterangan_bukti_lainnya ? $data->keterangan_bukti_lainnya : '' }}</td>
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
                    <th style="width: 30%">Rincian</th>
                    <th style="width: 15%">Jumlah</th>
                    <th style="width: 50%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td>HKI</td>
                    <td class="text-center">{{ $data->jumlah_hki ? $data->jumlah_hki : '' }}</td>
                    <td>{{ $data->keterangan_hki ? $data->keterangan_hki : '' }}</td>
                </tr>
                <tr>
                    <td class="text-center">2</td>
                    <td>Paten</td>
                    <td class="text-center">{{ $data->jumlah_paten ? $data->jumlah_paten : '' }}</td>
                    <td>{{ $data->keterangan_paten ? $data->keterangan_paten : '' }}</td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td>Penghargaan Nasional / Regional / Internal</td>
                    <td class="text-center">{{ $data->jumlah_penghargaan ? $data->jumlah_penghargaan : '' }}</td>
                    <td>{{ $data->keterangan_penghargaan ? $data->keterangan_penghargaan : '' }}</td>
                </tr>
                <tr>
                    <td class="text-center">4</td>
                    <td>Dokumen lainnya</td>
                    <td class="text-center">
                        {{ $data->jumlah_dokumen_lainnya ? $data->jumlah_dokumen_lainnya : '' }}</td>
                    <td>{{ $data->keterangan_dokumen_lainnya ? $data->keterangan_dokumen_lainnya : '' }}</td>
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
                    <th style="width: 30%">Kategori Penilaian</th>
                    <th style="width: 15%">Checklist</th>
                    <th style="width: 50%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td>Dapat Dihargai (Kriteria 1 - 8)</td>
                    <td class="text-center checkmark">{!! $data->dihargai ? '&#10004;' : '' !!}</td>
                    <td>{{ $data->keterangan_dihargai ? $data->keterangan_dihargai : '' }}</td>
                </tr>
                <tr>
                    <td class="text-center">2</td>
                    <td>Diadopsi Satker Lain (Kriteria 1 - 9)</td>
                    <td class="text-center checkmark">{!! $data->diadopsi ? '&#10004;' : '' !!}</td>
                    <td>{{ $data->keterangan_diadopsi ? $data->keterangan_diadopsi : '' }}</td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td>Percontohan Nasional (Kriteria 1 - 10)</td>
                    <td class="text-center checkmark">{!! $data->penilaian_percontohan ? '&#10004;' : '' !!}</td>
                    <td>{{ $data->keterangan_penilaian_percontohan ? $data->keterangan_penilaian_percontohan : '' }}
                    </td>
                </tr>
                <tr>
                    <td class="text-center">4</td>
                    <td>Tidak Ada Inovasi</td>
                    <td class="text-center checkmark">{!! $data->tidak_inovasi ? '&#10004;' : '' !!}</td>
                    <td>{{ $data->keterangan_tidak_inovasi ? $data->keterangan_tidak_inovasi : '' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="no-break">
        <div class="section-title">KESIMPULAN</div>
        <p style="text-align: justify;">{{ $data->kesimpulan ? $data->kesimpulan : '' }}</p>
    </div>

    <div class="no-break">
        <table class="no-border" style="margin-top: 30px;">
            <tr>
                <td class="text-center">
                </td>
                <td class="text-center">
                    <p>Surakarta,
                        {{ \Carbon\Carbon::parse($data->tanggal_ba)->locale('id')->translatedFormat('d F Y') }}
                    </p>
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    <strong>Satuan Pemeriksaan Internal</strong><br><br><br><br><br>
                    <u>{{ $data->spi ? $data->anggotaSPI->name : '' }}</u>
                </td>
                <td class="text-center">
                    <strong>Petugas Tim Kerja PPE</strong><br><br><br><br><br>
                    <u>{{ $data->ppe_1 ? $data->petugasPPE1->name : '' }}</u>
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    <strong>Kepala SPI,</strong><br><br><br><br><br>
                    <u>{{ $data->kepala_spi ? $data->kepalaSPI->name : '' }}</u>
                </td>
                <td class="text-center">
                    <br><br><br><br><br>
                    <u>{{ $data->ppe_2 ? $data->petugasPPE2->name : '' }}</u>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
