<?php

namespace App\Http\Controllers\Catin;

use App\DataTables\Catin\PengajuanDispensasiDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catin\PengajuanDispensasi\StorePengajuanDispensasiRequest;
use App\Http\Requests\Catin\PengajuanDispensasi\UpdatePengajuanDispensasiRequest;
use App\Models\Catin;
use App\Models\Dispensasi;
use App\Models\Master\Agama;
use App\Models\Master\Pendidikan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PengajuanDispensasiController extends Controller
{
    protected $modules = ['catin.pengajuan-dispensasi'];

    public function index(PengajuanDispensasiDataTable $dataTable)
    {
        return $dataTable->render('pages.catin.pengajuan-dispensasi.index');
    }

    public function create()
    {
        return view('pages.catin.pengajuan-dispensasi.create', [
            'religions' => Agama::select('id', 'agama')->get(),
            'educations' => Pendidikan::select('id', 'pendidikan')->get()
        ]);
    }

    public function store(StorePengajuanDispensasiRequest $request)
    {
        $data = $request->validated();
        $gender = [
            'pria_' => 'L',
            'wanita_' => 'P'
        ];
        $is_hamil = $request->has('is_pasangan_hamil');

        $catin = [
            'pria' => [],
            'wanita' => []
        ];

        foreach ($gender as $keyGender => $valueGender) {
            $data_catin = [];
            foreach ($data as $key => $value) {
                if (Str::startsWith($key, $keyGender)) {
                    $data_catin[Str::replaceFirst($keyGender, '', $key)] = $value;
                }
            }
            $data_catin['jenis_kelamin'] = $valueGender;

            $g = $valueGender == 'L' ? 'pria' : 'wanita';
            $catin[$g] = $data_catin;
        }

        // make sure nik is unique
        // ketika pengajuan dispensasi ditolak, nik yang sama bisa digunakan kembali setelah 3 bulan dari tanggal pengajuan

        $pria = Catin::with('dispensasi')->where('nik', $catin['pria']['nik'])->get()->sortByDesc('dispensasi.tanggal_pengajuan')->first();
        $wanita = Catin::with('dispensasi')->where('nik', $catin['wanita']['nik'])->get()->sortByDesc('dispensasi.tanggal_pengajuan')->first();

        if ($pria && $pria->dispensasi->status_persetujuan == 'REJECTED') {
            $diff = now()->diffInMonths($pria->dispensasi->tanggal_pengajuan);
            if ($diff < 3) {
                return \ResponseFormatter::error('NIK yang sama tidak dapat digunakan kembali dalam kurun waktu 3 bulan setelah pengajuan dispensasi ditolak');
            }
        } else if ($pria) {
            if ($pria->dispensasi->status_persetujuan != 'REJECTED') {
                return \ResponseFormatter::error('NIK yang sama sudah digunakan dalam pengajuan dispensasi sebelumnya');
            }
        }

        if ($wanita && $wanita->dispensasi->status_persetujuan == 'REJECTED') {
            $diff = now()->diffInMonths($wanita->dispensasi->tanggal_pengajuan);
            if ($diff < 3) {
                return \ResponseFormatter::error('NIK yang sama tidak dapat digunakan kembali dalam kurun waktu 3 bulan setelah pengajuan dispensasi ditolak');
            }
        } else if ($wanita) {
            if ($wanita->dispensasi->status_persetujuan != 'REJECTED') {
                return \ResponseFormatter::error('NIK yang sama sudah digunakan dalam pengajuan dispensasi sebelumnya');
            }
        }

        DB::beginTransaction();
        try {
            $dispensasi = Dispensasi::create([
                'register_id' => auth()->user()->register->id,
                'tanggal_pengajuan' => now(),
                'status_persetujuan' => 'SUBMITTED',
                'is_pasangan_hamil' => $is_hamil
            ]);

            foreach ($catin as $key => $value) {
                $value['dispensasi_id'] = $dispensasi->id;
                Catin::create($value);
            }

            DB::commit();
            return \ResponseFormatter::success('Dispensasi berhasil diajukan, silakan lengkapi berkas persyaratan untuk masing-masing calon pengantin.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return \ResponseFormatter::error('Pengajuan dispensasi tidak dapat dilakukan, mohon untuk mencoba kembali dalam beberapa saat');
        }
    }

    public function edit(Dispensasi $pengajuan_dispensasi)
    {
        return view('pages.catin.pengajuan-dispensasi.edit', [
            'dispensasi' => $pengajuan_dispensasi,
            'religions' => Agama::select('id', 'agama')->get(),
            'educations' => Pendidikan::select('id', 'pendidikan')->get()
        ]);
    }

    public function update(UpdatePengajuanDispensasiRequest $request, Dispensasi $pengajuan_dispensasi)
    {
        if ($pengajuan_dispensasi->status_persetujuan != 'SUBMITTED') {
            return \ResponseFormatter::error('Pengajuan tidak dapat diubah karena sudah diproses');
        }

        $data = $request->validated();
        $gender = [
            'pria_' => 'L',
            'wanita_' => 'P'
        ];
        $is_hamil = $request->has('is_pasangan_hamil');

        $catin = [
            'pria' => [],
            'wanita' => []
        ];

        foreach ($gender as $keyGender => $valueGender) {
            foreach ($data as $key => $value) {
                if (Str::startsWith($key, $keyGender)) {
                    $data_catin[Str::replaceFirst($keyGender, '', $key)] = $value;
                }
            }
            if ($valueGender == 'L') {
                $catin['pria'] = $data_catin;
            } else {
                $catin['wanita'] = $data_catin;
            }
        }

        $pria = Catin::with('dispensasi')->where('nik', $catin['pria']['nik'])->get()->sortByDesc('dispensasi.tanggal_pengajuan')->first();
        $wanita = Catin::with('dispensasi')->where('nik', $catin['wanita']['nik'])->get()->sortByDesc('dispensasi.tanggal_pengajuan')->first();

        if ($pria && $pria->dispensasi->status_persetujuan == 'REJECTED') {
            $diff = now()->diffInMonths($pria->dispensasi->tanggal_pengajuan);
            if ($diff < 3) {
                return \ResponseFormatter::error('NIK yang sama tidak dapat digunakan kembali dalam kurun waktu 3 bulan setelah pengajuan dispensasi ditolak');
            }
        } else if ($pria) {
            if ($pria->id != $pengajuan_dispensasi->catin_pria->id) {
                if ($pria->dispensasi->status_persetujuan != 'REJECTED') {
                    return \ResponseFormatter::error('NIK yang sama sudah digunakan dalam pengajuan dispensasi sebelumnya');
                }
            }
        }

        if ($wanita && $wanita->dispensasi->status_persetujuan == 'REJECTED') {
            $diff = now()->diffInMonths($wanita->dispensasi->tanggal_pengajuan);
            if ($diff < 3) {
                return \ResponseFormatter::error('NIK yang sama tidak dapat digunakan kembali dalam kurun waktu 3 bulan setelah pengajuan dispensasi ditolak');
            }
        } else if ($wanita) {
            if ($wanita->id != $pengajuan_dispensasi->catin_wanita->id) {
                if ($wanita->dispensasi->status_persetujuan != 'REJECTED') {
                    return \ResponseFormatter::error('NIK yang sama sudah digunakan dalam pengajuan dispensasi sebelumnya');
                }
            }
        }

        DB::beginTransaction();
        try {
            $pengajuan_dispensasi->update([
                'is_pasangan_hamil' => $is_hamil
            ]);
            foreach ($catin as $key => $value) {
                if ($key == 'pria') {
                    $pengajuan_dispensasi->catin_pria->update($value);
                } else {
                    $pengajuan_dispensasi->catin_wanita->update($value);
                }
            }
            DB::commit();
            return \ResponseFormatter::success('Data pengajuan dispensasi berhasil diubah');
        } catch (\Throwable) {
            DB::rollBack();
            return \ResponseFormatter::error('Tidak dapat mengubah data pengajuan dispensasi');
        }
    }

    public function destroy(Dispensasi $pengajuan_dispensasi)
    {
        DB::beginTransaction();
        try {

            if ($pengajuan_dispensasi->status_persetujuan != 'SUBMITTED') {
                return \ResponseFormatter::error('Pengajuan tidak dapat dihapus karena sudah diproses');
            }

            $pengajuan_dispensasi->catin_wanita->delete();
            $pengajuan_dispensasi->catin_pria->delete();
            $pengajuan_dispensasi->delete();
            DB::commit();
            return \ResponseFormatter::success('Pengajuan dispensasi berhasil dihapus');
        } catch (\Throwable $e) {
            DB::rollBack();
            return \ResponseFormatter::error('Tidak dapat menghapus data pengajuan dispensasi');
        }
    }

    public function download(Dispensasi $pengajuan_dispensasi)
    {
        $filePath = $pengajuan_dispensasi->file;
        if (!Storage::disk('public')->exists($filePath)) {
            return redirect()->route('catin.pengajuan-dispensasi.index')->with('error', 'Berkas tidak ditemukan');
        }
        return Storage::disk('public')->download($filePath);
    }

    //    public function print(Dispensasi $pengajuan_dispensasi) {
    //
    //        if ($pengajuan_dispensasi->status_persetujuan != 'APPROVED') {
    //            abort(404);
    //        }
    //
    //        $logo = null;
    //        try {
    //            $logo = "data:image/png;base64,".base64_encode(file_get_contents(public_path("assets/images/blitar.png")));
    //        } catch (\Throwable) {
    //        }
    //        $options = new Options();
    //        $options->set('isHtml5ParserEnabled', true);
    //        $options->set('isRemoteEnabled', true);
    //        $doc = new Dompdf($options);
    //        $doc->loadHtml(view('pages.catin.pengajuan-dispensasi.print.template', [
    //            'reg' => $pengajuan_dispensasi,
    //            'logo' => $logo
    //        ]));
    //        $doc->setPaper('F4', 'portrait');
    //        $doc->render();
    //
    //        return $doc->stream("Surat Permohonan Dispensasi Nikah.pdf", array("Attachment" => 1));
    //    }
}
