<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'nama' => 'Pasien',
                'email' => 'pasien@gmail.com',
                'password' => Hash::make('pasien'),
                'role' => 'pasien',
                'no_ktp' => '1234567890123456',
                'no_hp' => '081234567890', // tambahkan ini
            ],
            [
                'nama' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'role' => 'admin',
                'no_ktp' => '1234567890123457',
                'no_hp' => '081234567891', // tambahkan ini
            ],
            [
                'nama' => 'Dokter',
                'email' => 'dokter@gmail.com',
                'password' => Hash::make('dokter'),
                'role' => 'dokter',
                'no_ktp' => '1234567890123458',
                'no_hp' => '081234567892', // tambahkan ini
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
