<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'nama' => 'Admin',
                'alamat' => 'Jl. Contoh No.1',
                'no_ktp' => '1234567890123456',
                'no_hp' => '08123456789',
                'no_rm' => 'RM001',
                'role' => 'admin',
                'id_poli' => null,
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
            ],
            [
                'nama' => 'Dokter',
                'alamat' => 'Jl. Kesehatan No.2',
                'no_ktp' => '6543210987654321',
                'no_hp' => '082233445566',
                'no_rm' => 'RM002',
                'role' => 'dokter',
                'id_poli' => 1, // pastikan tabel poli sudah memiliki data ID 1
                'email' => 'dokter@gmail.com',
                'password' => Hash::make('dokter'),
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']], // cek berdasarkan email
                [
                    'nama' => $user['nama'],
                    'alamat' => $user['alamat'],
                    'no_ktp' => $user['no_ktp'],
                    'no_hp' => $user['no_hp'],
                    'no_rm' => $user['no_rm'],
                    'role' => $user['role'],
                    'id_poli' => $user['id_poli'],
                    'password' => $user['password'],
                ]
            );
        }
    }
}
