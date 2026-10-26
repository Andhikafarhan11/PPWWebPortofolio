<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class RandomProjectSeeder extends Seeder
{
    public function run(): void
    {
        $awalan = [
            'Sistem Informasi', 'Aplikasi Mobile', 'Platform E-Commerce', 
            'Dashboard Analitik', 'Manajemen Inventaris', 'Sistem Absensi Online',
            'Portal Berita Terintegrasi', 'Aplikasi Kasir Pintar', 'Sistem Rekam Medis',
            'Platform Reservasi Tiket', 'Aplikasi Manajemen Aset', 'Sistem Arsip Digital'
        ];

        $bidang = [
            'Rumah Sakit', 'Sekolah Menengah', 'Perguruan Tinggi', 'Pemerintah Desa',
            'Klinik Pratama', 'Toko Retail', 'Perusahaan Logistik', 'Perpustakaan Daerah',
            'Badan Usaha Milik Desa', 'Bengkel Kendaraan', 'Restoran Terpadu'
        ];

        $kategori = ['Web Development', 'Mobile App', 'UI/UX Design', 'Sistem Informasi'];

        for ($i = 1; $i <= 25; $i++) {
            $judulAcak = $awalan[array_rand($awalan)] . ' ' . $bidang[array_rand($bidang)] . ' ' . $i;

            Project::create([
                'judul'     => $judulAcak,
                'kategori'  => $kategori[array_rand($kategori)],
                'deskripsi' => 'Pengembangan ' . strtolower($judulAcak) . ' yang dirancang untuk mendukung efisiensi operasional dan pengolahan data terpusat.',
                'tautan'    => 'https://github.com/Andhikafarhan11/PPWWebPortofolio',
                'status'    => 'published',
            ]);
        }
    }
}