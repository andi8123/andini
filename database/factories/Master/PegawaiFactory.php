<?php

namespace Database\Factories\Master;

use App\Models\Master\Agama;
use App\Models\Master\Kecamatan;
use App\Models\Master\Kelurahan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PegawaiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kecamatan = Kecamatan::inRandomOrder()->first();
        return [
            'nip' => $this->faker->unique()->randomNumber(8),
            'nama' => $this->faker->name,
            'tempat_lahir' => $this->faker->city,
            'tanggal_lahir' => $this->faker->date(),
            'kecamatan_id' => $kecamatan->id,
            'kelurahan_id' => $kecamatan->kelurahan()->inRandomOrder()->first()->id,
            'agama_id' => Agama::inRandomOrder()->first()->id,
            'alamat' => $this->faker->address,
        ];
    }
}
