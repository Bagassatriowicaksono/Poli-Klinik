<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Poli;

class PoliSeeder extends Seeder
{
    public function run(): void
    {
        $polis = [
            ['nama_poli' => 'Poli Umum', 'keterangan' => 'Menangani pasien umum'],
            ['nama_poli' => 'Poli Gigi', 'keterangan' => 'Menangani kesehatan gigi'],
        ];

        foreach ($polis as $poli) {
            Poli::create($poli);
        }
    }
}
