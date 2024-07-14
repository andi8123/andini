<?php

namespace Database\Seeders;

use App\Models\Master\JabatanFungsional;
use App\Models\Master\Pegawai;
use App\Models\Master\Periode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JabatanFungsionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $periode = Periode::where('is_active', '1')->first();
        JabatanFungsional::create([
            'periode_id' => $periode->id,
            'kepala_upt' => Pegawai::factory()->create()->id,
            'pembina_utama_muda' => Pegawai::factory()->create()->id,
            'pembina' => Pegawai::factory()->create()->id,
            'sekretaris' => Pegawai::factory()->create()->id,
            'bendahara' => Pegawai::factory()->create()->id,
            'pengawas' => Pegawai::factory()->create()->id,
            'pengadministrasi_umum' => Pegawai::factory()->create()->id,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
    }
}
