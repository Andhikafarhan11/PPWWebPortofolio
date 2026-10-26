<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    public function definition(): array
    {
        // Pustaka kata dan topik IT berbahasa Indonesia
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

        $fakerId = \Faker\Factory::create('id_ID');

        // Menghasilkan kombinasi judul acak yang realistis (Bukan Latin)
        $judulAcak = $awalan[array_rand($awalan)] . ' ' . $bidang[array_rand($bidang)];

        return [
            'judul'     => $judulAcak,
            'kategori'  => $this->faker->randomElement(['Web Development', 'Mobile App', 'UI/UX Design', 'Sistem Informasi']),
            'deskripsi' => 'Pengembangan ' . strtolower($judulAcak) . ' yang dirancang menggunakan arsitektur modern untuk mendukung efisiensi operasional dan pengolahan data terpusat.',
            'tautan'    => 'https://github.com/Andhikafarhan11/PPWWebPortofolio',
            'status'    => 'published',
        ];
    }
}