<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstansiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            [
                'nama_instansi' => 'Dinas Pemberdayaan Perempuan, Perlindungan Anak, Pengendalian Penduduk dan KB Kabupaten Blitar',
                'nama_pendek' => 'Dinas P3APPKB',
                'alamat' => 'Jl. Cokroaminoto No.mor 12, Kepanjen Lor, Kec. Kepanjenkidul, Kota Blitar, Jawa Timur 66117',
                'telepon' => '087734343444343',
                'fax' => '0912343434',
                'email' => 'dinaskb.blitarkab@gmail.com',
                'website' => 'https://www.blitarkab.go.id/',
                'logo' => 'logo',
                'created_by' => 1,
                'created_at' => now('Asia/Jakarta'),
            ]
        ])->each(fn ($instansi) => \App\Models\Master\Instansi::create($instansi));
    }
}
