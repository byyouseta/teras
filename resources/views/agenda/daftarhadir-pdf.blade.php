<!DOCTYPE html>
<html>

<head>
    <title>Daftar Hadir {{ $agenda->nama_agenda }}</title>

    <style>
        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            height: 50px;

            /** Extra personal styles **/
            /* background-color: #03a9f4; */
            color: black;
            text-align: right;
            line-height: 12px;
        }

        body {
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            /* default tabel */
        }

        table th {
            font-size: 14px;
            font-weight: bold;
        }

        table td {
            font-size: 16px;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            height: 50px;

            /** Extra personal styles **/
            /* background-color: #03a9f4; */
            color: grey;
            text-align: right;
            font-size: 11px;
            line-height: 35px;
        }
    </style>
</head>

<body>
    <main>
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th class="align-middle pl-0">
                        <center><img src={{ public_path('assets/images/KopSurat.png') }} alt="Kop Surat"
                                style="width: 650px;" /></center>
                    </th>
                </tr>
            </thead>
        </table>
        <?php
        $arrhari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $hari = new DateTime($agenda->tanggal);
        $tanggal = new DateTime($agenda->tanggal);
        ?>
        <style type="text/css">
            table tr td,
            table tr th {
                font-size: 9pt;
            }

            hr.new4 {
                border: 2px solid black;
                margin-left: auto;
                margin-right: auto;
                margin-top: -1em;
                margin-bottom: 0em;
            }
        </style>

        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td colspan='4' style="text-align: center; font-size: 16px; ">
                        <h3>DAFTAR HADIR</h3>
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%; font-weight: bold; font-size: 11pt;">Hari</td>
                    <td style="width: 40%;  font-size: 11pt;">{{ $arrhari[$tanggal->format('N')] }}</td>
                    <td style="text-align: right; width: 15%; font-weight: bold; font-size: 11pt;">Tempat</td>
                    <td style="width: 35%; padding-left: 10px; font-size: 11pt;">{{ $agenda->ruangan->nama }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; vertical-align: top; font-size: 11pt;">Tanggal</td>
                    <td style="vertical-align: top;  font-size: 11pt;">{{ $tanggal->format('d-m-Y') }}</td>
                    <td style="text-align: right; font-weight: bold; vertical-align: top;  font-size: 11pt;">
                        Acara</td>
                    <td style="vertical-align: top; padding-left: 10px; font-size: 11pt; text-align: justify;">
                        {{ $agenda->nama_agenda }}
                    </td>
                </tr>
            </tbody>
        </table>

        <table style="width: 100%; margin-top: 20px; " border="1" cellspacing="0" cellpadding="5">
            <tr>
                <td style="width: 5%; font-weight: bold; text-align:center; border: 1px solid black; font-size: 10pt;">
                    No</td>
                <td style="width: 35%; font-weight: bold; text-align:center; border: 1px solid black; font-size: 10pt;">
                    NAMA</td>
                <td style="width: 35%; font-weight: bold; text-align:center; border: 1px solid black; font-size: 10pt;">
                    INSTANSI</td>
                <td style="width: 25%; font-weight: bold; text-align:center; border: 1px solid black; font-size: 10pt;">
                    WAKTU
                    PRESENSI</td>
            </tr>
            <?php $no = 1; ?>

            @foreach ($peserta as $user)
                <tr>
                    <td style="text-align: center; font-size: 11pt;">{{ $no++ }}</td>
                    <td style="font-size: 11pt;">{{ $user->name }}</td>
                    <td style="text-align: center; font-size: 11pt;">{{ $user->unit->nama_unit }}</td>
                    <td style="text-align: center; font-size: 11pt;">
                        {{ \Carbon\Carbon::parse($user->pivot->presensi_at)->format('d-m-Y H:i') }}</td>
                </tr>
            @endforeach
            @foreach ($tamu as $t)
                <tr>
                    <td style="text-align: center; font-size: 11pt;">{{ $no++ }}</td>
                    <td style="font-size: 11pt;">{{ $t->nama }}</td>
                    <td style="text-align: center; font-size: 11pt;">{{ $t->unit }}</td>
                    <td style="text-align: center; font-size: 11pt;">
                        {{ \Carbon\Carbon::parse($t->created_at)->format('d-m-Y H:i') }}</td>
                </tr>
            @endforeach
        </table>
    </main>
    <footer>
        Dicetak dari PATRIK (Rapat Elektronik) pada
        {{ \Carbon\Carbon::now()->format('d/m/Y h:i:s') }}
    </footer>
</body>

</html>
