<!DOCTYPE html>
<html lang="en">

<head>
    <title>Undangan Rapat {{ $agenda->nama_agenda }}</title>
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}
    <style>
        header {
            position: fixed;
            top: -40px;
            left: 0px;
            right: 0px;
            height: 0px;

            /** Extra personal styles **/
            /* background-color: #03a9f4; */
            color: black;
            text-align: right;
            line-height: 12px;
        }

        /* body {
            font-family: Arial, sans-serif;
        } */

        footer {
            position: fixed;
            bottom: -60px;
            left: 20px;
            right: 20px;
            height: 120px;

            /** Extra personal styles **/
            /* background-color: #03a9f4; */
            color: black;
            text-align: right;
            font-size: 11px;
            line-height: 12px;
        }
    </style>
</head>
<header>
    <table class="table table-borderless" style="margin-bottom : 0px;padding-bottom:0px;">
        <thead>
            <tr>
                <th class="align-middle pl-0">
                    <center>
                        <img src={{ public_path('assets/images/KopSurat.png') }} alt="Kop Surat" style="width: 650px;" />
                    </center>
                </th>
            </tr>
        </thead>
    </table>
</header>

<body>
    <main>
        <?php
        $arrhari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $hari = new DateTime($agenda->tanggal);
        $tanggal = new DateTime($agenda->tanggal);
        ?>
        <style type="text/css">
            table tr td,
            table tr th {
                font-size: 10pt;

            }

            hr.new4 {
                border: 2px solid black;
                margin-left: auto;
                margin-right: auto;
                margin-top: 0em;
                margin-bottom: 0em;
            }

            p.ex1 {
                margin-left: auto;
                margin-right: auto;
                margin-top: auto;
                margin-bottom: auto;
            }
        </style>
        @php
            $jmlundangan = $agenda->user->count();

            $urutan2 = ceil($jmlundangan / 2);

            foreach ($agenda->user as $index => $user) {
                $undangan[$index] = $user->name;
            }

            $kanan = $urutan2;
            $nokiri = 1;
            $nokanan = $urutan2 + 1;

        @endphp

        <table style="width: 100%; margin-top:70px; padding-top:0px; margin-bottom:20px; padding-bottom:0px">
            <tbody>
                <tr>
                    <th colspan='4' class="text-center" style="padding-top: 0px;">
                        <h4 style="padding-bottom:1px; margin-bottom:1px; font-weight: bold; font-size: 16pt;">Undangan
                        </h4>
                        <p style="padding-top: 1px; padding-bottom:1px; margin-top:1px; margin-bottom:1px;">
                            {{ $agenda->no_undangan }}
                        </p>
                    </th>
                </tr>

            </tbody>
        </table>
        <table style="width: 100%; margin-top:0%; padding-top:0%; margin-bottom:0%; padding-bottom:0%; ">
            <tr>
                <td colspan='2' style="padding-left: 40px">Yth. Bapak Ibu </td>
            </tr>
            @for ($i = 0; $i < $urutan2; $i++)
                <tr>
                    <td style="padding-top:1px;padding-bottom:1px; padding-left:45px; ">
                        {{ $nokiri . '. ' . $undangan[$i] }}
                    </td>
                    @php
                        $kanan = $urutan2 + $i;
                        $nokiri++;
                    @endphp
                    @if (!empty($undangan[$kanan]))
                        <td style="padding-top:1px;padding-bottom:1px; padding-right:40px; ">
                            {{ $nokanan . '. ' . $undangan[$kanan] }}</td>
                    @endif
                    @php
                        $nokanan++;
                    @endphp
                </tr>
            @endfor
        </table>
        <table
            style="margin-top:1px; text-align:left; width:100%; padding-top:0px; margin-bottom:0px; padding-bottom:0px;">
            <tbody>
                <tr>
                    <td colspan='3' style="padding-top: 1px; padding-bottom:1px; padding-left:40px;">Di RSUP
                        Surakarta</td>
                </tr>
                <tr>
                    <td colspan='3' style="padding-top: 1px; padding-bottom:1px; padding-left:40px;">Mengharap
                        kehadiran Bapak/Ibu/Saudara/i pada :
                    </td>
                </tr>
                <tr>
                    <td style=" width: 25%; padding-top: 1px; padding-bottom:1px; padding-left:60px;font-weight:bold;">
                        Hari,Tanggal
                    </td>
                    <td style="width: 5%; padding-top: 1px; padding-bottom:1px;text-align:right; font-weight:bold;">
                        :</td>
                    <td style="width: 70%; padding-top: 1px; padding-bottom:1px;font-weight:bold;">
                        {{ $arrhari[\Carbon\Carbon::parse($tanggal)->format('N')] }},
                        {{ \Carbon\Carbon::parse($tanggal)->locale('id')->isoFormat('D MMMM Y') }}</td>
                </tr>
                <tr>
                    <td style=" width: 25%; padding-top: 1px; padding-bottom:1px; padding-left:60px;font-weight:bold;">
                        Waktu</td>
                    <td style="width: 5%; padding-top: 1px; padding-bottom:1px;text-align:right; font-weight:bold;">
                        :</td>
                    <td style="width: 70%; padding-top: 1px; padding-bottom:1px;font-weight:bold;">
                        {{ \Carbon\Carbon::parse($agenda->waktu_mulai)->format('H:i') }} -
                        {{ \Carbon\Carbon::parse($agenda->waktu_selesai)->format('H:i') }} WIB</td>
                </tr>
                <tr>
                    <td style=" width: 25%; padding-top: 1px; padding-bottom:1px; padding-left:60px;font-weight:bold;">
                        Tempat</td>
                    <td style="width: 5%; padding-top: 1px; padding-bottom:1px;text-align:right; font-weight:bold;">
                        :</td>
                    <td style="width: 70%; padding-top: 1px; padding-bottom:1px;font-weight:bold;">
                        {{ $agenda->ruangan->nama }}</td>
                </tr>
                <tr>
                    <td style=" width: 25%; padding-top: 1px; padding-bottom:1px; padding-left:60px;font-weight:bold;">
                        Acara</td>
                    <td style="width: 5%; padding-top: 1px; padding-bottom:1px;text-align:right; font-weight:bold;">
                        :</td>
                    <td
                        style="width: 70%; padding-top: 1px; padding-bottom:1px;font-weight:bold; word-wrap: break-word; text-align:justify;">
                        {!! nl2br(e($agenda->nama_agenda)) !!}
                    </td>
                </tr>
                <tr>
                    <td
                        style=" width: 25%; padding-top: 1px; padding-bottom:1px; padding-left:60px;font-weight:bold; vertical-align: top;">
                        Keterangan</td>
                    <td
                        style="width: 5%; padding-top: 1px; padding-bottom:1px;text-align:right; font-weight:bold; vertical-align: top;">
                        :</td>
                    <td
                        style="width: 70%; padding-top: 1px; padding-bottom:1px;font-weight:bold; word-wrap: break-word; text-align:justify;">

                        {!! nl2br(e($agenda->keterangan)) !!}
                    </td>
                </tr>
                <tr>
                    <td colspan='3' style="padding-top: 1px; padding-bottom:1px; padding-left:40px;">Atas
                        kehadirannya diucapkan terima
                        kasih.</td>
                </tr>

            </tbody>
        </table>
        <table style="width: 100%; margin-top:20px; padding-top:0px; margin-bottom:0px; padding-bottom:0px;">
            <tbody>
                <tr>
                    <td style="width: 50%; "></td>
                    <td style="text-align:center; width: 50%; padding-right:40px; ">
                        {{ $agenda->jab_pengundang }}</td>
                </tr>

                <tr>
                    <td style="width: 50%; "></td>
                    <td style="text-align:center; width: 50%; padding-right:40px; padding-top:70px; font-weight:bold;">
                        {{ $agenda->pengundang }}</td>
                </tr>
            </tbody>

        </table>
    </main>
    <footer>
        <table class="table table-sm table-borderless" style="margin-bottom:100px;">
            <tr>
                <td
                    style="color: black; padding-top:0px; padding-bottom:0px; font-size:11px; text-align:center; border:1px solid black">
                    Kementerian Kesehatan tidak menerima suap dan/ atau gratifikasi dalam bentuk apapun. Jika terdapat
                    potensi suap atau gratifikasi silahkan laporkan melalui HALO KEMENKES 1500567 dan
                    <a href='https://wbs.kemkes.go.id'>https://wbs.kemkes.go.id</a>. Untuk verifikasi keaslian
                    tandatangan elektronik, silahkan unggah dokumen
                    pada laman <a href='https://tte.kominfo.go.id/verifyPDF'>https://tte.kominfo.go.id/verifyPDF</a>
                </td>
                <td class="text-right" style='width:20%'>
                    <img src="{{ public_path('assets/images/kars_paripurna.png') }}" alt="Logo KARS" width="50"
                        height="50">
                    <img src="{{ public_path('assets/images/LogoBLUSpeed.png') }}" alt="Logo Blu Speed" width="50"
                        height="50">
                </td>
            </tr>
            <tr>
                <td style="color: grey; padding-top:20px; padding-bottom:0px; font-size:11px; text-align:right;"
                    colspan='2'>
                    Dicetak dari PATRIK (Rapat Elektronik) pada {{ \Carbon\Carbon::now()->format('d/m/Y h:i:s') }}
                </td>
            </tr>
        </table>
    </footer>

</body>

</html>
