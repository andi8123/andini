<?php

namespace App\Http\Controllers\Admin\Catin;

use App\DataTables\Catin\VerifikasiCatinDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Asesmen\StoreAsesorJadwalRequest;
use App\Http\Requests\Asesmen\StoreGenerateDispensasiRequest;
use App\Models\Assesor\CatinPersyaratan;
use App\Models\Catin;
use App\Models\Dispensasi;
use App\Models\Master\Periode;
use App\Models\Asesmen\JadwalAsesmen;
use App\Models\Asesmen\PenilaianAsesmen;
use App\Models\AsesmenPenilaian;
use App\Models\Master\JabatanFungsional;
use App\Models\Master\PersyaratanDispensasi;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use ResponseFormatter;

class VerifikasiCatinController extends Controller
{
    protected $modules = ["catin.verifikasi-catin"];
    protected $actions = [];

    public function index(VerifikasiCatinDataTable $datatable)
    {
        $filterStatus = request()->get('status');
        if ($filterStatus) {
            $dataTable = new VerifikasiCatinDataTable($filterStatus);
        }
        return $datatable->render('pages.admin.verifikasi-catin.index');
    }

    public function verify(StoreAsesorJadwalRequest $request, Dispensasi $dispensasi)
    {

        $periode_aktif = Periode::getCurrent();
        $tanggal_asesmen = explode('T', $request->tanggal_assesmen);
        $tanggal_jam_asemen = $tanggal_asesmen[0] . ' ' . $tanggal_asesmen[1];
        $dispensasi->update([
            'status_persetujuan' => $request->status_persetujuan,
        ]);

        $jadwalAssesment = JadwalAsesmen::create([
            'dispensasi_id' => $dispensasi->id,
            'periode_id' => $periode_aktif->id,
            'tanggal_asesmen' => $tanggal_jam_asemen,
            'status' => 'SUBMITTED',
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);

        PenilaianAsesmen::create([
            'asesmen_id' => $jadwalAssesment->id,
            'asesor_id' => $request->assesor_id,
        ]);

        return ResponseFormatter::success('Verifikasi berhasil disetujui!', 200);
    }

    public function reset(Dispensasi $dispensasi)
    {
        $dispensasi->update([
            'status_persetujuan' => 'SUBMITTED',
        ]);
        $periode_aktif = Periode::getCurrent();
        $jadwalAssesment = $dispensasi->jadwalAsesmen()->where('periode_id', $periode_aktif->id)->first();
        PenilaianAsesmen::where('asesmen_id', $jadwalAssesment->id)->delete();
        JadwalAsesmen::where('dispensasi_id', $dispensasi->id)->delete();

        return ResponseFormatter::success('Reset dispensasi berhasil!', 200);
    }

    public function show(Dispensasi $verifikasi_catin)
    {
        $catin_pria = Catin::where('dispensasi_id', $verifikasi_catin->id)->where('jenis_kelamin', 'L')->first();
        $persyaratan_catin_pria =  $catin_pria->jumlahBerkasWajib();
        $catin_wanita = Catin::where('dispensasi_id', $verifikasi_catin->id)->where('jenis_kelamin', 'P')->first();
        $persyaratan_catin_wanita = $catin_wanita->jumlahBerkasWajib();
        $semua_persyaratan = PersyaratanDispensasi::where('is_wajib', 1)->count();
        // dd($semua_persyaratan, $persyaratan_catin_pria, $persyaratan_catin_wanita);
        return view('pages.admin.verifikasi-catin.show', compact('verifikasi_catin', 'persyaratan_catin_pria', 'persyaratan_catin_wanita', 'semua_persyaratan'));
    }

    public function edit($id)
    {
        $persyaratan_catin = CatinPersyaratan::where('id', $id)->with('persyaratan')->first();
        return response()->json($persyaratan_catin);
    }

    public function update(Request $request, $id)
    {
        $catin_persyaratan = CatinPersyaratan::find($id);
        $catin_persyaratan->status = $request->status_verifikasi;
        $catin_persyaratan->keterangan = $request->catin_keterangan;
        $catin_persyaratan->save();
        return response()->json(['message' => 'Persyaratan berhasil diverifikasi']);
    }

    public function persyaratanCatin(Catin $catin)
    {
        $activePeriod = Periode::getCurrent();
        $catinId = $catin->id;
        $query = PersyaratanDispensasi::query();
        $persyaratan = $query->newQuery()
            ->leftJoin('catin_persyaratan as cp', function ($join) use ($catinId) {
                $join->on('ref_persyaratan.id', '=', 'cp.persyaratan_id')
                    ->where('cp.catin_id', '=', $catinId);
            })
            ->where('ref_persyaratan.periode_id', '=', $activePeriod?->id)
            ->where('is_active', '=', '1')
            ->select(
                'ref_persyaratan.id as ref_persyaratan_id',
                'ref_persyaratan.nama_persyaratan as ref_nama_persyaratan',
                'ref_persyaratan.keterangan as ref_keterangan',
                'ref_persyaratan.file_pendukung as ref_file_pendukung',
                'ref_persyaratan.is_wajib as ref_is_wajib',
                'cp.id as cp_id',
                'cp.file_path as cp_file_path',
                'cp.status as cp_status',
                'cp.keterangan as cp_keterangan',
            );
        $semua_persyaratan = $persyaratan->get();

        $count_berkas = $semua_persyaratan->where('ref_is_wajib', 1)->count();
        $count_existing = $semua_persyaratan->where('ref_is_wajib', 1)->where('cp_status', 'APPROVED')->count();

        return view('pages.admin.verifikasi-catin.edit', compact('catin', 'semua_persyaratan', 'count_berkas', 'count_existing'));
    }

    public function cetakAsesmen(Dispensasi $dispensasi)
    {
        $catin_pria = Catin::where("dispensasi_id", $dispensasi->id)
            ->where("jenis_kelamin", "L")
            ->first();
        $catin_perempuan = Catin::where("dispensasi_id", $dispensasi->id)
            ->where("jenis_kelamin", "P")
            ->first();

        $kepela_upt = JabatanFungsional::where("periode_id", $dispensasi->jadwalAsesmen?->periode_id)
            ->first();

        if ($kepela_upt == null) {
            return ResponseFormatter::error("Kepala UPT tidak ditemukan, silahkan melakukan pendataan jabatan terlebih dahulu", code: 404);
        }

        $jadwalAssesment = AsesmenPenilaian::where('asesmen_id', $dispensasi->jadwalAsesmen->id)->get();

        $data = $jadwalAssesment->map(function ($item) use ($catin_pria, $catin_perempuan, $kepela_upt) {
            return (object) [
                'catin' => (object) [
                    'pria' => (object)[
                        'nama' => $catin_pria->nama_lengkap,
                        'alamat' => $catin_pria->alamat,
                        'kecamatan' => $catin_pria->kecamatan->nama_kecamatan,
                        'kelurahan' => $catin_pria->kelurahan->nama_kelurahan,
                        'umur' => now()->diffInYears($catin_pria->tanggal_lahir),
                    ],
                    'wanita' => (object) [
                        'nama' => $catin_perempuan->nama_lengkap,
                        'alamat' => $catin_perempuan->alamat,
                        'kecamatan' => $catin_perempuan->kecamatan->nama_kecamatan,
                        'kelurahan' => $catin_perempuan->kelurahan->nama_kelurahan,
                        'umur' => now()->diffInYears($catin_perempuan->tanggal_lahir),
                    ],
                ],
                'penilaian' => (object) [
                    'lama_hubungan' => $item->lama_hubungan,
                    'alasan_menikah' => $item->alasan_menikah,
                    'gaya_berpacaran' => $item->gaya_berpacaran,
                    'pekerjaan_catin' => $item->pekerjaan_catin,
                    'penghasilan_catin' => $item->penghasilan_catin,
                    'persetujuan_keluarga' => $item->persetujuan_keluarga,
                    'pola_hubungan' => $item->pola_hubungan,
                    'catatan' => $item->catatan,
                    'status_rekomendasi' => $item->status_rekomendasi,
                    'keterangan' => $item->keterangan,
                ],
                'kepala_upt' => (object) [
                    'nip' => $kepela_upt->nip,
                    'nama' => $kepela_upt->nama
                ],
                'asesor' => $item->asesor->nama,
                'wali' => $catin_perempuan->nama_wali,
            ];
        });

        // dd($data);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(view('pages.admin.verifikasi-catin.partials.print-asesmen-template', compact('data')));
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('Asesmen dispensasi ' . $dispensasi->id, array("Attachment" => 0));
    }

    public function generate(StoreGenerateDispensasiRequest $request, Dispensasi $dispensasi)
    {

        $fileName = $request->nomor_surat . '.' . $request->file('file')->getClientOriginalExtension();
        $request->file('file')->storeAs('Surat_Dispensasi', $fileName);
        $filePath = 'Surat_Dispensasi/' . $fileName;
        $dispensasi->update([
            'nomor_surat' => $request->nomor_surat,
            'file' => $filePath,
            'status_persetujuan' => "RECEIVED",
        ]);

        return ResponseFormatter::success('Generate berhasil!', 200);
    }

    public function downloadDispensasi($id)
    {
        $dispensasi = Dispensasi::findOrFail($id);
        $filePath = $dispensasi->file;
        if (!Storage::disk('public')->exists($filePath)) {
            return redirect()->back()->withErrors('File tidak ditemukan.');
        }
        return Storage::disk('public')->download($filePath);
    }
}
