<?php

namespace Database\Seeders;

use App\Models\Master\Periode;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersyaratanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            [
                'periode_id' => Periode::getCurrent()['id'],
                'nama_persyaratan' => 'Fotokopi KTP',
                'keterangan' => 'Fotokopi KTP yang masih berlaku',
                'is_wajib' => '1',
                'is_active' => '1',
                'created_by' => 1,
                'updated_by' => 1
                
            ],
            [
                'periode_id' => Periode::getCurrent()['id'],
                'nama_persyaratan' => 'Fotokopi Akta Kelahiran',
                'keterangan' => 'Fotokopi Akta Kelahiran yang masih berlaku',
                'is_wajib' => '1',
                'is_active' => '1',
                'created_by' => 1,
                'updated_by' => 1
                
            ],
            [
                'periode_id' => Periode::getCurrent()['id'],
                'nama_persyaratan' => 'Surat Pernyataan Persetujuan Dispensasi Nikah yang ditandatangani orang tua/wali',
                'keterangan' => 'Surat Pernyataan Persetujuan Dispensasi Nikah yang ditandatangani orang tua/wali',
                'is_wajib' => '1',
                'is_active' => '1',
                'created_by' => 1,
                'updated_by' => 1
                
            ],
            [
                'periode_id' => Periode::getCurrent()['id'],
                'nama_persyaratan' => 'Surat Penolakan dari KUA/n7',
                'keterangan' => 'Surat Penolakan dari KUA/n7',
                'is_wajib' => '1',
                'is_active' => '1',
                'created_by' => 1,
                'updated_by' => 1
                
            ],
            [
                'periode_id' => Periode::getCurrent()['id'],
                'nama_persyaratan' => 'Fotokopi Kartu Keluarga (KK)',
                'keterangan' => 'Fotokopi Kartu Keluarga (KK)',
                'is_wajib' => '1',
                'is_active' => '1',
                'created_by' => 1,
                'updated_by' => 1
                
            ],
            [
                'periode_id' => Periode::getCurrent()['id'],
                'nama_persyaratan' => 'Fotokopi Ijazah Terakhir',
                'keterangan' => 'Fotokopi Ijazah Terakhir',
                'is_wajib' => '1',
                'is_active' => '1',
                'created_by' => 1,
                'updated_by' => 1
                
            ],
            [
                'periode_id' => Periode::getCurrent()['id'],
                'nama_persyaratan' => 'Bukti Kehamilan',
                'keterangan' => 'Bukti Kehamilan dapat berupa Foto Buku KIA/Foto Surat Dokter/Foto Usg (Khusus Dokumen Catin Perempuan)',
                'is_wajib' => '0',
                'is_active' => '1',
                'created_by' => 1,
                'updated_by' => 1
                
            ]
        ])->each(function ($persyaratan) {
            \App\Models\Master\PersyaratanDispensasi::create($persyaratan);
        });
    }
}
