<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            MenusSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            PermissionsSeeder::class,
            AccessSeeder::class,
            KecamatanSeeder::class,
            AgamaSeeder::class,
            PendidikanSeeder::class,
            SiteSettingSeeder::class,
            FAQSeeder::class,
            PeriodeSeeder::class,
            JabatanFungsionalSeeder::class,
            PersyaratanSeeder::class,
            InstansiSeeder::class,
        ]);
    }
}
