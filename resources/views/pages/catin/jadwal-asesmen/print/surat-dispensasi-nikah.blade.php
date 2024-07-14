<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Permohonan Dispensasi Nikah</title>
    <style>
        /* @page {
            size: a4 portrait;
        }

        @page orientation-portrait {
            size: portrait;
        }

        @page orientation-landscape {
            size: landscape;
        }

        .landscape-page {
            page: orientation-landscape;
        }

        .portrait-page {
            page: orientation-portrait;
        }

        .landscape {
            page: landscape;

        } */

        body {
            font-family: Roboto, "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 14px;
            font-weight: 400;
            margin: 0;

        }

        body * {
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
            align-items: start;
        }

        table td,
        table th {
            padding: 0px;
            border: 1px solid black;
            vertical-align: top;
        }

        .th-center {
            vertical-align: middle !important;
        }



        .pe-td {
            width: 150px;
        }

        table.header-table {
            border: 0;
        }

        table.header-table td {
            padding: 0;
            border: 0;
        }

        .table-borderless {
            border: 0;
            margin-left: -.1em;
        }

        .footer {
            margin-top: 35rem;
            float: right;
        }

        .table-borderless td,
        table.table-borderless th {
            padding: 0 0.2rem;
            border: 0;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .w-full {
            width: 210mm !important;
        }

        .w-signature {
            width: 170mm !important;
        }

        .tr-full {
            width: calc(210mm - 4em);
        }

        .page-break {
            page-break-before: always;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            height: 50px;
        }

        .footer-text {
            font-size: 0.5em;
        }
    </style>
</head>

<body>
    <div class="portait-page">

        <header>
            <table class="header-table" style="width: 100%">
                <tr>
                    {{-- @if ($logo)
                        <td rowspan="5" style="padding: 0;">

                        </td>
                    @endif --}}

                    <td>
                        <img src="{{ $logo }}" style="width:8em; height:8em;float:left; margin:0; padding:0;""
                            alt="logo">
                        <p style="text-align: center; margin-bottom: .1em; margin-top: .1em;font-size:1.2em;">
                            PEMERINTAH KABUPATEN BLITAR
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                            DINAS PEMBERDAYAAN PEREMPUAN, PERLINDUNGAN ANAK,
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                            PENGENDALIAN PENDUDUK DAN KELUARGA BERENCANA
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </p>
                        <p style="text-align: center; margin-bottom: .2em; margin-top: .2em; font-size:1.5em;">
                            <b>
                                UPT
                                PERLINDUNGAN
                                PEREMPUAN
                                DAN
                                ANAK
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </b>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style=" text-align: center; font-size:1em;">Jl. HOS Cokroaminoto No. 12 Blitar Telp/Fax :
                            (0342)
                            801053 / 807718
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="text-align: center; font-size: 1em;">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            Website : www.dppkb-p3a.blitarkab.go.id /
                            Email: ppa_upt@blitarkab.go.id
                        </p>
                    </td>
                </tr>
                <tr></tr>
                <tr></tr>
                <tr>
                    <td colspan="2">
                        <hr style="margin-top: 0rem;">
                    </td>
                </tr>
            </table>
        </header>
        <main style="padding:0 4rem;line-height:1.5rem;margin-top:2rem">
            <div class="container">
                <center>
                    <p class="fs-3">SURAT KETERANGAN</p>
                    <p class="fs-3">NOMOR {{ $jadwalasesmen->dispensasi->nomor_surat }}</p>
                </center>
                <br />
                <p>Berdasarkan Peraturan:</p>
                <ol style="margin-left: 1.5em">
                    <li>Undang-Undang No 35 Tahun 2014 Tentang perubahan atas Undang-Undang Nomor 23 Tahun 2002 Tentang
                        Perlindungan Anak.
                    </li>
                    <li>
                        Undang-Undang Nomor 16 Tahun 2019 Tentang Perubahan Atas Undang-Undang Nomor 1 Tahun 1974
                        Tentang
                        Perkawinan. Pada Pasal 7 yang menyatakan bahwa perkawinan hanya diizinkan apabila laki-laki dan
                        perempuan sudah mencapai umur 19 (Sembilan belas) Tahun.
                    </li>
                    <li>
                        Peraturan Daerah Kabupaten Blitar Nomor 3 Tahun 2020 Tentang Penyelenggaraan Perlindungan dan
                        Pemenuhan
                        Hak Anak.
                    </li>
                </ol>
                <br />
                <p>&nbsp;&nbsp;&nbsp;&nbsp;Maka kami melaksanakan asesmen terhadap Calon Pengantin dan Wali
                    pada hari
                    @php
                        setLocale(LC_TIME, 'id');
                    @endphp
                    <b>
                        {{ \Carbon\Carbon::parse($jadwalasesmen->dispensasi->tanggal_surat)->formatLocalized('%A') }}
                    </b>
                    tanggal
                    <b>
                        {{ \Carbon\Carbon::parse($jadwalasesmen->dispensasi->tanggal_surat)->formatLocalized('%d %B') }}
                    </b>
                    tahun {{ \Carbon\Carbon::parse($jadwalasesmen->dispensasi->tanggal_surat)->year }} dengan identitas
                    pemohon sebagai berikut :
                </p>
            </div>
            <table class="table-borderless">
                <tbody>
                    <tr class="tr-full">
                        <td>Nama Pemohon</td>
                        <td>:</td>
                        <td colspan="2">
                            {{$jadwalasesmen->penilaian->nama_pemohon}}
                        </td>
                    </tr>
                    <tr class="tr-full">
                        <td colspan="3">
                            <p style="text-align: left; margin-bottom: 0.1em;">Orang Tua/Wali dari</p>
                        </td>

                    </tr>
                </tbody>
            </table>
            <table class="table-borderless">
                <tbody>
                    <tr class="tr-full">
                        <td colspan="3">
                            <h4 style="text-align: left; margin-bottom: 0.1em;">Calon Istri</h4>
                        </td>
                    </tr>
                    <tr class="tr-full">
                        <td>Nama</td>
                        <td>:</td>
                        <td colspan="2">
                            {{ $jadwalasesmen->dispensasi->catin_wanita->nama_lengkap }}
                        </td>
                    </tr>
                    <tr class="tr-full">
                        <td>Umur</td>
                        <td>:</td>
                        <td colspan="2">
                            {{ \Carbon\Carbon::parse($jadwalasesmen->dispensasi->catin_wanita->tanggal_lahir)->age }}
                        </td>
                    </tr>
                    <tr class="tr-full">
                        <td>Agama</td>
                        <td>:</td>
                        <td colspan="2">
                            {{ $jadwalasesmen->dispensasi->catin_wanita->agama->agama }}
                        </td>
                    </tr>
                    <tr class="tr-full">
                        <td>Pekerjaan</td>
                        <td>:</td>
                        <td colspan="2">
                            {{ $jadwalasesmen->dispensasi->catin_wanita->pekerjaan }}
                        </td>
                    </tr>
                    <tr class="tr-full">
                        <td>Alamat</td>
                        <td>:</td>
                        <td colspan="2">
                            {{ $jadwalasesmen->dispensasi->catin_wanita->alamat }}, Kec.
                            {{ $jadwalasesmen->dispensasi->catin_wanita->kecamatan->nama_kecamatan }}, Kel.
                            {{ $jadwalasesmen->dispensasi->catin_wanita->kelurahan->nama_kelurahan }}
                        </td>
                    </tr>
                </tbody>

            </table>
            <table class="table-borderless" style="margin-top: 1em">
                <tbody>
                    <tr class="tr-full">
                        <td colspan="3">
                            <h4 style="text-align: left; margin-bottom: 0.1em;">Calon Suami</h4>
                        </td>
                    </tr>
                    <tr class="tr-full">
                        <td>
                            Nama
                        </td>
                        <td>:</td>
                        <td colspan="2">
                            {{ $jadwalasesmen->dispensasi->catin_pria->nama_lengkap }}
                        </td>
                    </tr>
                    <tr class="tr-full">
                        <td>Umur</td>
                        <td>:</td>
                        <td colspan="2">
                            {{ \Carbon\Carbon::parse($jadwalasesmen->dispensasi->catin_pria->tanggal_lahir)->age }}
                        </td>
                    </tr>
                    <tr class="tr-full">
                        <td>Agama</td>
                        <td>:</td>
                        <td colspan="2">
                            {{ $jadwalasesmen->dispensasi->catin_pria->agama->agama }}
                        </td>
                    </tr>
                    <tr class="tr-full">
                        <td>Pekerjaan</td>
                        <td>:</td>
                        <td colspan="2">
                            {{ $jadwalasesmen->dispensasi->catin_pria->pekerjaan }}
                        </td>
                    </tr>
                    <tr class="tr-full">
                        <td>Alamat</td>
                        <td>:</td>
                        <td colspan="2">
                            {{ $jadwalasesmen->dispensasi->catin_pria->alamat }}, Kec.
                            {{ $jadwalasesmen->dispensasi->catin_pria->kecamatan->nama_kecamatan }}, Kel.
                            {{ $jadwalasesmen->dispensasi->catin_pria->kelurahan->nama_kelurahan }}
                        </td>
                    </tr>
                </tbody>

            </table>
            <footer style="text-align: center;">
                <small class="footer-text">
                    <i>
                        Dokumen ini telah ditandatangani secara elektronik yang diterbitkan oleh Balai Sertifikasi
                        Elektronik
                        (BSrE), BSSN
                    </i>
                </small>

            </footer>
            <div class="container page-break" style="margin-top: 2em">
                <h4>Hasil Wawancara : </h4>
                <ol style="margin-left: 1.5em">
                    <li>Calon Pengantin sudah berpacaran selama {!! $jadwalasesmen->penilaian->lama_hubungan !!}.
                    </li>
                    <li>
                        Alasan menikah karena {!! $jadwalasesmen->penilaian->alasan_menikah !!}
                    </li>
                    <li>
                        Gaya berpacaran kedua catin diketahui {!! $jadwalasesmen->penilaian->gaya_berpacaran !!}

                    </li>
                    <li>
                        Kedua keluarga catin {{ $jadwalasesmen->penilaian->persetujuan_keluarga }}
                    </li>
                    <li>
                        Catin laki-laki bekerja sebagai
                        {{ $jadwalasesmen->penilaian->pekerjaan_catin }} dengan penghasilan
                        {{ 'Rp. ' . number_format($jadwalasesmen->penilaian->penghasilan_catin, 0, ',', '.') }},-

                    </li>
                    <li>
                        Catin laki-laki memiliki pendidikan
                        {{ $jadwalasesmen->dispensasi->catin_pria->pendidikan->pendidikan }}. Sedangkan
                        Catin perempuan memiliki pendidikan
                        {{ $jadwalasesmen->dispensasi->catin_wanita->pendidikan->pendidikan }}.
                    </li>
                    <li>
                        {{ $jadwalasesmen->penilaian->catatan }}
                    </li>
                    <li>
                        Diketahui pada saat asesmen, pola hubungan kedua catin {{ $jadwalasesmen->penilaian->pola_hubungan }}
                    </li>
                </ol>
                <br>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;Berdasarkan hasil asesmen maka keputusan kami serahkan sepenuhnya kepada
                    majelis
                    yang menangani perkara
                    ini. Demikian hasil wawancara kami, semoga dijadikan bahan pertimbangan Majelis Hakim Pengadilan
                    Agama
                    Blitar yang menangani perkara ini dalam memberikan keputusan dan disampaikan terimakasih.
                </p>
                <br>
                <center>
                    <p>Blitar, {{ \App\Helpers\Formatter::date(now()) }}</p>
                </center>
                <br>
                <table class="table-borderless" style="padding:0;width: 100%;text-align:center;">
                    <tbody>

                        <tr>
                            <td>
                                Mengetahui, <br>
                                KEPALA DINAS PEMBERDAYAAN
                                PEREMPUAN, PERLINDUNGAN ANAK,
                                PENGENDALIAN PENDUDUK, DAN
                                KELUARGA BERENCANA ,
                            </td>
                            <td>
                                <br>
                                KEPALA UPT PERLINDUNGAN
                                PEREMPUAN DAN ANAK,
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <br>
                                <br>
                                <br>
                                ..........................
                            </td>
                            <td>
                                <br>
                                <br>
                                <br>
                                ..........................
                            </td>
                        </tr>
                        <tr class="tr-full">
                            <td>
                                <b><u>{{ $jabatanFungsional->as_pembina_utama_muda->nama }} </u></b><br>
                                Pembina Utama Muda <br>
                                NIP. {{ $jabatanFungsional->as_pembina_utama_muda->nip }}
                            </td>
                            <td>
                                <b><u> {{ $jabatanFungsional->as_kepala_upt->nama }}</u></b> <br>
                                Penata <br>
                                NIP. {{ $jabatanFungsional->as_kepala_upt->nip }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <footer style="text-align: center;">

                <small class="footer-text">
                    <i>
                        Dokumen ini telah ditandatangani secara elektronik yang diterbitkan oleh Balai Sertifikasi
                        Elektronik
                        (BSrE), BSSN
                    </i>
                </small>
            </footer>
        </main>

    </div>


</body>

</html>
