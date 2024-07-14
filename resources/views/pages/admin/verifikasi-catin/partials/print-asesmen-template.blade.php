<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <style>
    body {
      font-family: Roboto, "Helvetica Neue", Helvetica, Arial, sans-serif;
      font-size: 14px;
      font-weight: 400;
      margin: 0;
    }

    table {
      border-collapse: collapse;
    }

    table td,
    table th {
      padding: .5em;
      border: 1px solid black;
    }

    table.table-borderless td {
      padding: .1em .2em .1em 0;
      border: 0;
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

    .page_break {
      page-break-before: always;
    }

    .table-borderless,
    .table-borderless td,
    .table-borderless th {}
  </style>
</head>

<body>
  <main>
    <div>
      <center>
        <h3 style="margin-bottom: 2em;">Asesmen Penilaian</h3>
      </center>
      @foreach ($data as $i => $d)
        <table class="table-borderless" style="border:none;width:100%;margin-top:2em;">
          <thead>
            <tr>
              <td>
                Nama Catin Pria
              </td>
              <td>:</td>
              <td> {{ $d->catin->pria->nama }}</td>
              <td>
                Nama Catin Wanita
              </td>
              <td>:</td>
              <td>{{ $d->catin->wanita->nama }}</td>
            </tr>
            <tr>
              <td>
                Alamat Catin Pria
              </td>
              <td>:</td>
              <td>{{ $d->catin->pria->alamat }},
                Kel. {{ $d->catin->pria->kelurahan }} ,
                Kec. {{ $d->catin->pria->kecamatan }}</td>
              <td>
                Alamat Catin Wanita
              </td>
              <td>:</td>
              <td>{{ $d->catin->wanita->alamat }},
                Kel. {{ $d->catin->wanita->kelurahan }} ,
                Kec. {{ $d->catin->wanita->kecamatan }}</td>
            </tr>
            <tr>
              <td>
                Umur Catin Pria
              </td>
              <td>:</td>
              <td> {{ $d->catin->pria->umur }} Tahun</td>
              <td>
                Umur Catin Wanita
              </td>

              <td>:</td>
              <td>
                {{ $d->catin->wanita->umur }} Tahun
              </td>
            </tr>
          </thead>
        </table>

        <table style="margin-top:1rem;">
          <thead>
            <tr>
              <th>Lama Hubungan Terjalin</th>
              <th>Alasan/Tujuan Menikah</th>
              <th>Gaya Berpacaran Catin/Hamil</th>
              <th>Pekerjaan dan Penghasilan Catin</th>
              <th>Persetujuan Keluarga</th>
              <th>Pola Hubungan Orang Tua dan Anak</th>
              <th>Keterangan Tambahan
              <th>Hasil</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                {{ $d->penilaian->lama_hubungan }}
              </td>
              <td>
                {{ $d->penilaian->alasan_menikah }}
              </td>
              <td>
                {{ $d->penilaian->gaya_berpacaran }}
              </td>
              <td>
                {{ $d->penilaian->pekerjaan_catin }} dengan penghasilan {{ $d->penilaian->penghasilan_catin }}
              </td>
              <td>
                {{ $d->penilaian->persetujuan_keluarga }}
              </td>
              <td>
                {{ $d->penilaian->pola_hubungan }}
              </td>
              <td>
                {{ $d->penilaian->keterangan }}
              </td>
              <td>
                {{ ucwords(str_replace('_', ' ', strtolower($d->penilaian->status_rekomendasi))) }}
              </td>
            </tr>
          </tbody>
        </table>

        <footer style="margin-top:1rem">
          <table class="table-borderless" style="width:100%">
            <tbody>

              <tr>
                <td style="text-align: center;">
                  <p>
                    Mengetahui,<br />
                    Kepala UPT PPA Kab. Blitar
                  </p>
                </td>

                <td style="text-align: center;">
                  <p>
                    Asesor
                  </p>
                </td>

                <td style="text-align: center;">
                  Blitar, {{ \App\Helpers\Formatter::date(now()) }} <br>
                  Wali Calon Pengantin
                </td>
              </tr>
              <tr>
                <td style="padding-top:4rem;text-align: center;">
                  ……………………………
                </td>

                <td style="padding-top:4rem;text-align: center;">
                  ……………………………
                </td>

                <td style="padding-top:4rem;text-align: center;">
                  ……………………………
                </td>
              </tr>
              <tr>
                <td style="text-align: center;">
                  {{ $d->kepala_upt->nama }}
                </td>
                <td style="text-align: center;">
                  {{ $d->asesor }}
                </td>
                <td style="text-align: center;">
                  {{ $d->wali }}
                </td>
              </tr>
              <tr>
                <td style="text-align: center;">
                  NIP: {{ $d->kepala_upt->nip }}
                </td>
              </tr>
            </tbody>
          </table>
        </footer>
        @if ($i < count($data) - 1)
          <div class="page_break"></div>
        @endif
      @endforeach
    </div>

  </main>


</body>
