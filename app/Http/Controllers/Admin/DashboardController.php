<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catin;
use App\Models\Dashboard\Asesor;
use App\Models\Dashboard\Jadwal;
use App\Models\Dashboard\news;
use App\Models\Dashboard\Pengajuan;
use App\Models\Dashboard\RefKecamatan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $countCatinPria = Catin::where('jenis_kelamin', 'L')->count();
        $countCatinWanita = Catin::where('jenis_kelamin', 'P')->count();
        $jumlah_jadwal = Jadwal::jadwal(); // Mengambil jumlah jadwal dari model Jadwal
        $jumlah_data = Asesor::jumlahData(); // Mengambil jumlah data dari model Asesor, contoh penambahan untuk ilustrasi
        $jumlah_pengajuan = Pengajuan::pengajuan();
        $jadwal = Jadwal::all();
        $news = News::all();
        $jumlah_disetujui = Pengajuan::disetujui();
        $jumlah_pengajuan_per_kecamatan = DB::table('catin')
            ->select('kecamatan_id', DB::raw('COUNT(*) as jumlah_pengajuan'))
            ->groupBy('kecamatan_id')
            ->get();

        $nama_kecamatan = RefKecamatan::all('nama_kecamatan', 'id')->toArray();;
        return view('pages.admin.dashboard', [
            'countCatinPria' => $countCatinPria,
            'countCatinWanita' => $countCatinWanita,
            'jumlah_jadwal' => $jumlah_jadwal,
            'jumlah_data' => $jumlah_data, // Menyimpan jumlah data asesor dalam variabel 'jumlah_data'
            'jumlah_pengajuan' => $jumlah_pengajuan,
            'jumlah_disetujui' => $jumlah_disetujui,
            'jadwal' => $jadwal,
            'news' => $news,
            'jumlah_pengajuan_per_kecamatan' => $jumlah_pengajuan_per_kecamatan,
            'nama_kecamatan' => json_encode($nama_kecamatan),
            // tambahkan variabel jumlah_pengajuan_per_kecamatan ke dalam array
        ]);
    }


    public function usiaPria()
    {
        $countCatinPria = Catin::where('jenis_kelamin', 'L')->count();
        $listCatin = Catin::where('jenis_kelamin', 'L')
            ->select([
                'age' => DB::raw('YEAR(CURDATE()) - YEAR(tanggal_lahir) as age'),
                'countAge' => DB::raw('COUNT(*)  as countAge')
            ])
            ->groupBy(DB::raw('YEAR(CURDATE()) - YEAR(tanggal_lahir)'))
            ->get();

        $listCatin = $listCatin->map(function ($catin) use ($countCatinPria) {
            return [
                'catin_id' => $catin->id,
                'catin_name' => 'Usia ' . $catin->age,
                'percentage' => round(($catin->countAge / $countCatinPria) * 100),
            ];
        })->toArray();


        $labels = array_column($listCatin, 'catin_name');
        $series = array_column($listCatin, 'percentage');

        return response()->json(['labels' => $labels, 'series' => $series]);
    }
    public function usiaWanita()
    {
        $countCatinWanita = Catin::where('jenis_kelamin', 'P')->count();
        $listCatin = Catin::where('jenis_kelamin', 'P')
            ->select([
                'age' => DB::raw('YEAR(CURDATE()) - YEAR(tanggal_lahir) as age'),
                'countAge' => DB::raw('COUNT(*)  as countAge')
            ])
            ->groupBy(DB::raw('YEAR(CURDATE()) - YEAR(tanggal_lahir)'))
            ->get();

        $listCatin = $listCatin->map(function ($catin) use ($countCatinWanita) {
            return [
                'catin_id' => $catin->id,
                'catin_name' => 'Usia ' . $catin->age,
                'percentage' => round(($catin->countAge / $countCatinWanita) * 100),
            ];
        })->toArray();


        $labels = array_column($listCatin, 'catin_name');
        $series = array_column($listCatin, 'percentage');

        return response()->json(['labels' => $labels, 'series' => $series]);
    }
}
