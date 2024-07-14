<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect(
            [
                [
                    'periode' => '2023/2024',
                    'tahun' => '2023',
                    'keterangan' => 'Periode Pengajuan 2023 sampai 2024',
                    'is_active' => '0',
                    'created_by' => 1,
                    'updated_by' => 1
                ],
                [
                    'periode' => '2024/2025',
                    'tahun' => '2024',
                    'keterangan' => 'Periode Pengajuan 2024 sampai 2025',
                    'is_active' => '1',
                    'created_by' => 1,
                    'updated_by' => 1
                ]
            ]
        )->each(function ($periode) {
            \App\Models\Master\Periode::create($periode);
        });
    }
}
