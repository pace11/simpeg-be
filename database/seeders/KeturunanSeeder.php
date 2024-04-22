<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KeturunanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('keturunan')->insert([
            [
                'title' => 'PD',
                'description' => 'Putra Daerah',
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            ],
            [
                'title' => 'PDP',
                'description' => 'Putra Daerah Pendatang',
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            ],
            [
                'title' => 'NPD',
                'description' => 'Non Putra Daerah',
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            ],
        ]);
    }
}
