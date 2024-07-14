<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@arkatama.test',
            'email_verified_at' => now(),
            'password' => Hash::make('12345'),
            'remember_token' => Str::random(10),
        ]);

        $admin->assignRole('admin');

        // $assesor = User::create([
            // 'name' => 'Assesor',
            // 'email' => 'asesor@arkatama.test',
            // 'email_verified_at' => now(),
            // 'password' => Hash::make('12345'),
            // 'remember_token' => Str::random(10),
        // ]);
        // $assesor->assignRole('asesor');



        $adminUPT = User::create([
            'name' => 'Pengadilan Agama',
            'email' => 'pa@arkatama.test',
            'email_verified_at' => now(),
            'password' => Hash::make('12345'),
            'remember_token' => Str::random(10),
        ]);
        $adminUPT->assignRole('pengadilan-agama');

        // for ($i = 1; $i <= 10; $i++) {
            // $camaba = User::create([
                // 'name' => 'Catin ' . $i,
                // 'email' => 'catin' . $i . '@arkatama.test',
                // 'email_verified_at' => now(),
                // 'password' => Hash::make('12345'),
                // 'remember_token' => Str::random(10),
            // ]);
            // $camaba->assignRole('catin');
        // }
    }
}
