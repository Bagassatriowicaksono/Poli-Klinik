<?php

namespace Database\Seeders;

use App\Models\Poli;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $polis = [
            [
                'nama_poli' => 'Poli Anak',
                'keterangan' => 'Poli anak yang akan menyelesaikan masalah anak',
            ],

            [
                'nama_poli' => 'Poli Gigi',
                'keterangan' => 'Poli anak yang akan menyelesaikan masalah anak',
            ],
        ];

        foreach ($polis as $poli) {
            Poli::create($poli);
        }
    }
}