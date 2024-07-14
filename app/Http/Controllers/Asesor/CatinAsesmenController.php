<?php

namespace App\Http\Controllers\Asesor;

use App\DataTables\Asesor\CatinAsesmenDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Asesmen\UpdateCatinAsesmenRequest;
use App\Models\Admin\Asesor;
use App\Models\Asesmen\JadwalAsesmen;
use App\Models\AsesmenPenilaian;
use App\Models\Catin;
use App\Models\Dispensasi;
use App\Models\Master\JabatanFungsional;
use App\Models\Persyaratan;
use App\Models\Register;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Dompdf\Options;
use Dompdf\Dompdf;
use iio\libmergepdf\Merger;
use ResponseFormatter;

class CatinAsesmenController extends Controller
{
    protected $modules = ["asesor.catin-asesmen"];
    protected $actions = [];

    public function index(CatinAsesmenDataTable $dataTable)
    {
        return $dataTable->render('pages.asesor.catin-asesmen.index', ['modules' => $this->modules, 'actions' => $this->actions]);
    }

    public function show(Dispensasi $catin_asesmen)
    {
        $pria = $catin_asesmen->catin_pria->id;
        $wanita = $catin_asesmen->catin_wanita->id;
        $persyaratan = (object) [
            'pria' => Persyaratan::with([
                'catin_persyaratan' => function ($q) use ($pria) {
                    $q->where('catin_id', $pria);
                }
            ])->get(),
            'wanita' => Persyaratan::with([
                'catin_persyaratan' => function ($q) use ($wanita) {
                    $q->where('catin_id', $wanita);
                }
            ])->get(),
        ];

        $asesmen = $this->isAsesmenPenilaianExists(Auth::id());

        $now = now();
        $end = Carbon::parse($catin_asesmen->asesmen_jadwal->tanggal_asesmen)->greaterThanOrEqualTo($now);

        $data = (object) [
            'catin_asesmen' => $catin_asesmen,
            'persyaratan' => $persyaratan,
            'asesmen' => $asesmen,
            'asesmen_penilaian' => $catin_asesmen->asesmen_jadwal->asesmen_penilaian,
            'berakhir' => $end,
        ];

        return view('pages.asesor.catin-asesmen.show', ['data' => $data, 'modules' => $this->modules, 'actions' => $this->actions]);
    }

    public function edit(AsesmenPenilaian $catin_asesmen)
    {
        return response()->json([
            ...collect($catin_asesmen->toArray())
        ]);
    }

    public function update(UpdateCatinAsesmenRequest $request, AsesmenPenilaian $catin_asesmen)
    {
        $now = now();
        $end = Carbon::parse($catin_asesmen->asesmen_jadwal->tanggal_asesmen)->greaterThanOrEqualTo($now);
        if ($end) {
            return ResponseFormatter::error("Asesmen tidak dapat disimpan, karena asesmen telah berakhir", code: 500);
        }

        DB::beginTransaction();
        try {
            if ($catin_asesmen->updateOrFail($request->validated())) {
                DB::commit();
                return ResponseFormatter::success("Asesmen berhasil disimpan");
            } else {
                DB::rollBack();
                return ResponseFormatter::error("Gagal menyimpan asesmen", code: 500);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormatter::error("Gagal menyimpan asesmen", code: 500);
        }
    }

    public function printAsesmenPenilaian(AsesmenPenilaian $catin_asesmen)
    {
        if ($this->isAsesmenPenilaianExists(Auth::id())) {
            $logo = null;
            try {
                $logo = "data:image/png;base64," . base64_encode(file_get_contents(public_path("assets/images/logos/logo-kab-blitar.jpg")));
            } catch (\Throwable) {
            }

            $catin_pria = Catin::where("dispensasi_id", $catin_asesmen->asesmen_jadwal->dispensasi->id)
                ->where("jenis_kelamin", "L")
                ->first();
            $catin_perempuan = Catin::where("dispensasi_id", $catin_asesmen->asesmen_jadwal->dispensasi->id)
                ->where("jenis_kelamin", "P")
                ->first();
            $jabatan = JabatanFungsional::where("periode_id", $catin_asesmen->asesmen_jadwal->periode_id)
                ->first();
            Carbon::setLocale('id');
            $tanggal_surat = Carbon::parse($catin_asesmen->asesmen_jadwal->dispensasi->tanggal_surat);
            $wali_pria = isset($catin_asesmen->asesmen_jadwal->dispensasi->catin_pria->nama_wali)
                ? $catin_asesmen->asesmen_jadwal->dispensasi->catin_pria->nama_wali
                : 'null';

            $wali_wanita = isset($catin_asesmen->asesmen_jadwal->dispensasi->catin_wanita->nama_wali)
                ? $catin_asesmen->asesmen_jadwal->dispensasi->catin_wanita->nama_wali
                : 'null';

            $pemohon = ($wali_pria !== 'null' && $wali_wanita !== 'null')
                ? $wali_pria . ' (wali dari ' . $catin_asesmen->asesmen_jadwal->dispensasi->catin_pria->nama_lengkap . ') & ' . $wali_wanita . ' (wali dari ' . $catin_asesmen->asesmen_jadwal->dispensasi->catin_wanita->nama_lengkap . ')'
                : ($wali_pria !== 'null' ? $wali_pria . ' (wali dari ' . $catin_asesmen->asesmen_jadwal->dispensasi->catin_pria->nama_lengkap . ')' : $wali_wanita . ' (wali dari ' . $catin_asesmen->asesmen_jadwal->dispensasi->catin_wanita->nama_lengkap . ')');
            if ($jabatan == null) {
                return redirect()->back()->with('error', 'Kepala UPT tidak ditemukan, silahkan melakukan pendataan terlebih dahulu!!');
            }
            $data = (object) [
                'catin' => (object) [
                    'pria' => (object) [
                        'nama' => $catin_pria->nama_lengkap,
                        'alamat' => $catin_pria->alamat,
                        'kecamatan' => $catin_pria->kecamatan->nama_kecamatan,
                        'kelurahan' => $catin_pria->kelurahan->nama_kelurahan,
                        'umur' => now()->diffInYears($catin_pria->tanggal_lahir),
                        'agama' => $catin_pria->agama->agama,
                        'pekerjaan' => $catin_pria->pekerjaan,
                        'pendidikan' => $catin_pria->pendidikan->pendidikan,
                    ],
                    'wanita' => (object) [
                        'nama' => $catin_perempuan->nama_lengkap,
                        'alamat' => $catin_perempuan->alamat,
                        'kecamatan' => $catin_perempuan->kecamatan->nama_kecamatan,
                        'kelurahan' => $catin_perempuan->kelurahan->nama_kelurahan,
                        'umur' => now()->diffInYears($catin_perempuan->tanggal_lahir),
                        'agama' => $catin_perempuan->agama->agama,
                        'pekerjaan' => $catin_perempuan->pekerjaan,
                        'pendidikan' => $catin_perempuan->pendidikan->pendidikan,
                    ],
                ],
                'penilaian' => (object) [
                    'nama_pemohon' => $catin_asesmen->nama_pemohon,
                    'lama_hubungan' => $catin_asesmen->lama_hubungan,
                    'alasan_menikah' => $catin_asesmen->alasan_menikah,
                    'gaya_berpacaran' => $catin_asesmen->gaya_berpacaran,
                    'pekerjaan_catin' => $catin_asesmen->pekerjaan_catin,
                    'penghasilan_catin' => $catin_asesmen->penghasilan_catin,
                    'persetujuan_keluarga' => $catin_asesmen->persetujuan_keluarga,
                    'pola_hubungan' => $catin_asesmen->pola_hubungan,
                    'catatan' => $catin_asesmen->catatan,
                    'status_rekomendasi' => $catin_asesmen->status_rekomendasi,
                    'keterangan' => $catin_asesmen->keterangan,
                ],
                'jadwal' => (object) [
                    'nomor_surat' => $catin_asesmen->asesmen_jadwal->dispensasi->nomor_surat,
                    'tanggal_surat' => (object) [
                        'hari' => $tanggal_surat->translatedFormat('l'),
                        'tanggal' => $tanggal_surat->translatedFormat('d'),
                        'bulan' => $tanggal_surat->translatedFormat('F'),
                        'tahun' => $tanggal_surat->translatedFormat('Y'),
                    ],
                ],
                'kepala_upt' => (object) [
                    'nip' => $jabatan->as_kepala_upt->nip,
                    'nama' => $jabatan->as_kepala_upt->nama
                ],
                'pembina_utama_muda' => (object) [
                    'nip' => $jabatan->as_pembina_utama_muda->nip,
                    'nama' => $jabatan->as_pembina_utama_muda->nama
                ],
                'pembina' => (object) [
                    'nip' => $jabatan->as_pembina->nip,
                    'nama' => $jabatan->as_pembina->nama
                ],
                'asesor' => $catin_asesmen->asesor->nama,
                'pemohon' => $pemohon,
            ];

            $merger = new Merger;
            $dompdf = new Dompdf;

            $dompdf->loadHtml(view('pages.asesor.catin-asesmen.prints.surat-keterangan', compact('data', 'logo')));
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $merger->addRaw($dompdf->output());

            unset($dompdf);

            $dompdf = new Dompdf;
            $dompdf->loadHtml(view('pages.asesor.catin-asesmen.prints.asesmen-penilaian', compact('data')));
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $merger->addRaw($dompdf->output());

            $createdPdf = $merger->merge();
            return response($createdPdf)
                ->withHeaders([
                    'Content-Type' => 'application/pdf',
                    'Cache-Control' => 'no-store, no-cache',
                    'Content-Disposition' => 'inline; filename="Asesmen-Penilaian.pdf"',
                ]);
        } else {
            return redirect()->back()->with('error', 'Data asesmen penilaian tidak ditemukan');
        }
    }

    protected function isAsesmenPenilaianExists($user_id)
    {
        return AsesmenPenilaian::where('asesor_id', Asesor::where('user_id', $user_id)->first()->id)
            ->whereNotNull('status_rekomendasi')
            ->exists();
    }
}
