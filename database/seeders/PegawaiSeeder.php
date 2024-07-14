<?php

namespace Database\Seeders;

use App\Models\Master\JabatanFungsional;
use Database\Factories\Master\PegawaiFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PegawaiFactory::new()->count(10)->create();
    }
}
