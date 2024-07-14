<?php

namespace App\Http\Controllers\Catin;

use App\DataTables\Catin\JadwalAsesmenDataTable;
use App\Http\Controllers\Controller;
use App\Models\Asesmen\JadwalAsesmen;
use App\Models\Master\Periode;
use Dompdf\Dompdf;

class JadwalAsesmenController extends Controller
{
    protected $modules = ['catin.jadwal-asesmen'];

    public function index(JadwalAsesmenDataTable $dataTable)
    {
        return $dataTable->render('pages.catin.jadwal-asesmen.index');
    }

    public function printSuratDispensasiNikah(JadwalAsesmen $jadwalasesmen)
    {
        $logo = null;
        try {
            $logo = "data:image/png;base64," . base64_encode(file_get_contents(public_path("assets/images/logos/logo-kab-blitar.jpg")));
        } catch (\Throwable) {
        }
        $jadwalasesmen = $jadwalasesmen->loadMissing(['dispensasi', 'penilaian']);
        $jabatanFungsional = Periode::find($jadwalasesmen->periode_id)->jabatanFungsional
            ->loadMissing(['as_pembina_utama_muda', 'as_pembina', 'as_kepala_upt']);


        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('pages.catin.jadwal-asesmen.print.surat-dispensasi-nikah', compact('jadwalasesmen', 'logo', 'jabatanFungsional')));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        return $dompdf->stream('surat-dispensasi-nikah.pdf', ['Attachment' => 0]);
    }
}
