<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AgamaSeeder::class);
        $this->call(PendidikanKkSeeder::class);
        $this->call(StatusPerkawinanKkSeeder::class);
        $this->call(StatusHubunganKkSeeder::class);
        $this->call(JenisPekerjaanKkSeeder::class);
        $this->call(GolonganSeeder::class);
        $this->call(JabatanSeeder::class);
        $this->call(KeturunanSeeder::class);
        $this->call(PendidikanTerakhirSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PegawaiSeeder::class);
        $this->call(SpotifyNotifSeeder::class);
    }
}
