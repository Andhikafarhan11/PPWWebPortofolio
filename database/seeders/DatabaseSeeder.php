<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun dengan role 'admin'
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'Admin Andhika',
                'password' => Hash::make('password123'),
                'role'     => 'admin',
            ]
        );

        // 2. Akun dengan role 'user' (Non-Admin untuk uji error 403)
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name'     => 'Junaidi',
                'password' => Hash::make('password123'),
                'role'     => 'user',
            ]
        );

        // 3. Data sampel Project Portofolio
        Project::create([
            'judul'     => 'Sistem Informasi Manajemen Laboratorium SMAN 1 Mertoyudan',
            'kategori'  => 'Web Application',
            'deskripsi' => 'Aplikasi berbasis web untuk pelacakan inventaris dan peminjaman alat laboratorium.',
            'tautan'    => 'https://github.com/username/sim-lab',
            'status'    => 'published',
        ]);
    }
}