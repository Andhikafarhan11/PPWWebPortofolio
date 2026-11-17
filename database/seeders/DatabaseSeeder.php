<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Technology;
use App\Models\Project;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

        // 3. Seed Data Kategori beserta Slug
        $catWeb = Category::updateOrCreate(['slug' => 'web-application'], ['name' => 'Web Application']);
        $catMobile = Category::updateOrCreate(['slug' => 'mobile-application'], ['name' => 'Mobile Application']);
        $catDesign = Category::updateOrCreate(['slug' => 'ui-ux-design'], ['name' => 'UI/UX Design']);
        $catData = Category::updateOrCreate(['slug' => 'data-science'], ['name' => 'Data Science']);

        // 4. Seed Data Teknologi beserta Slug
        $techLaravel = Technology::updateOrCreate(['slug' => 'laravel'], ['name' => 'Laravel']);
        $techKotlin = Technology::updateOrCreate(['slug' => 'kotlin'], ['name' => 'Kotlin']);
        $techTailwind = Technology::updateOrCreate(['slug' => 'tailwind-css'], ['name' => 'Tailwind CSS']);
        $techMysql = Technology::updateOrCreate(['slug' => 'mysql'], ['name' => 'MySQL']);
        $techFigma = Technology::updateOrCreate(['slug' => 'figma'], ['name' => 'Figma']);
        $techBootstrap = Technology::updateOrCreate(['slug' => 'bootstrap'], ['name' => 'Bootstrap']);

        // Pastikan project lama yang belum punya slug terisi otomatis
        Project::whereNull('slug')->get()->each(function ($p) {
            $p->slug = Str::slug($p->judul);
            $p->save();
        });

        // 5. Seed 11 Data Sampel Project (10 Published + 1 Draft) untuk Uji Search, Filter, Sort, & Pagination
        $samples = [
            [
                'judul'             => 'Sistem Informasi Manajemen Laboratorium SMAN 1 Mertoyudan',
                'category_id'       => $catWeb->id,
                'kategori'          => 'Web Application',
                'short_description' => 'Sistem inventaris dan peminjaman alat laboratorium sekolah berbasis Laravel.',
                'deskripsi'         => 'Aplikasi berbasis web untuk pelacakan inventaris dan peminjaman alat serta bahan laboratorium secara terintegrasi.',
                'project_date'      => '2026-10-15',
                'tautan'            => 'https://github.com/username/sim-lab',
                'status'            => 'published',
                'techs'             => [$techLaravel->id, $techMysql->id, $techBootstrap->id],
            ],
            [
                'judul'             => 'Aplikasi Mobile Peminjaman Alat Lab Android',
                'category_id'       => $catMobile->id,
                'kategori'          => 'Mobile Application',
                'short_description' => 'Aplikasi mobile Android menggunakan Kotlin dan Jetpack Compose.',
                'deskripsi'         => 'Aplikasi mobile Android yang terhubung dengan REST API menggunakan Retrofit untuk memproses peminjaman alat laboratorium.',
                'project_date'      => '2026-11-01',
                'tautan'            => 'https://github.com/username/mobile-lab',
                'status'            => 'published',
                'techs'             => [$techKotlin->id, $techLaravel->id],
            ],
            [
                'judul'             => 'Laravel Blog & Content Management System',
                'category_id'       => $catWeb->id,
                'kategori'          => 'Web Application',
                'short_description' => 'Platform publikasi artikel dengan fitur pencarian dan filter kategori.',
                'deskripsi'         => 'Aplikasi manajemen artikel blog berbasis Laravel 12 dengan fitur multi-author, manajemen tag, dan optimasi SEO.',
                'project_date'      => '2026-08-20',
                'tautan'            => 'https://github.com/username/laravel-blog',
                'status'            => 'published',
                'techs'             => [$techLaravel->id, $techTailwind->id, $techMysql->id],
            ],
            [
                'judul'             => 'Desain UI/UX Sistem Akademik Terpadu',
                'category_id'       => $catDesign->id,
                'kategori'          => 'UI/UX Design',
                'short_description' => 'Prototipe interaktif aplikasi akademik mahasiswa menggunakan Figma.',
                'deskripsi'         => 'Perancangan antarmuka pengguna dan pengalaman pengguna (UI/UX) lengkap dengan design system dan wireframe.',
                'project_date'      => '2026-07-10',
                'tautan'            => 'https://figma.com/@username',
                'status'            => 'published',
                'techs'             => [$techFigma->id],
            ],
            [
                'judul'             => 'E-Commerce Katalog Produk UMKM Lokal',
                'category_id'       => $catWeb->id,
                'kategori'          => 'Web Application',
                'short_description' => 'Website katalog produk UMKM dengan keranjang belanja dinamis.',
                'deskripsi'         => 'Platform pemasaran digital untuk UMKM dengan fitur filter harga, pencarian produk, dan integrasi pembayaran.',
                'project_date'      => '2026-05-12',
                'tautan'            => 'https://github.com/username/umkm-store',
                'status'            => 'published',
                'techs'             => [$techLaravel->id, $techBootstrap->id, $techMysql->id],
            ],
            [
                'judul'             => 'Portal Portofolio Developer Interaktif',
                'category_id'       => $catWeb->id,
                'kategori'          => 'Web Application',
                'short_description' => 'Aplikasi web portofolio pribadi dengan fitur galeri foto dan autentikasi.',
                'deskripsi'         => 'Sistem manajemen portofolio berbasis Laravel Breeze yang dilengkapi upload thumbnail, multiple gallery, dan RBAC.',
                'project_date'      => '2026-11-10',
                'tautan'            => 'https://github.com/username/portfolio-app',
                'status'            => 'published',
                'techs'             => [$techLaravel->id, $techTailwind->id, $techMysql->id],
            ],
            [
                'judul'             => 'Aplikasi Pelacak Jadwal Kereta Api Mobile',
                'category_id'       => $catMobile->id,
                'kategori'          => 'Mobile Application',
                'short_description' => 'Aplikasi informasi jadwal keberangkatan kereta antarkota secara real-time.',
                'deskripsi'         => 'Aplikasi Android berbasis Kotlin untuk memantau jadwal kereta api rute Yogyakarta, Solo, dan Semarang.',
                'project_date'      => '2026-06-18',
                'tautan'            => 'https://github.com/username/train-schedule',
                'status'            => 'published',
                'techs'             => [$techKotlin->id],
            ],
            [
                'judul'             => 'Redesign Antarmuka Aplikasi Streaming Anime',
                'category_id'       => $catDesign->id,
                'kategori'          => 'UI/UX Design',
                'short_description' => 'Studi kasus redesign UI/UX aplikasi mobile streaming video.',
                'deskripsi'         => 'Eksplorasi desain antarmuka bertema gelap (dark mode) untuk meningkatkan kenyamanan menonton dan navigasi.',
                'project_date'      => '2026-09-05',
                'tautan'            => 'https://figma.com/@username',
                'status'            => 'published',
                'techs'             => [$techFigma->id],
            ],
            [
                'judul'             => 'Sistem Reservasi Kamar Hotel Online',
                'category_id'       => $catWeb->id,
                'kategori'          => 'Web Application',
                'short_description' => 'Aplikasi pemesanan kamar hotel dengan filter ketersediaan tanggal.',
                'deskripsi'         => 'Sistem informasi perhotelan berbasis Laravel dan MySQL untuk manajemen tipe kamar, pemesanan, dan laporan bulanan.',
                'project_date'      => '2026-04-22',
                'tautan'            => 'https://github.com/username/hotel-booking',
                'status'            => 'published',
                'techs'             => [$techLaravel->id, $techBootstrap->id, $techMysql->id],
            ],
            [
                'judul'             => 'Dashboard Analitik Evaluasi Proyek Scrum',
                'category_id'       => $catData->id,
                'kategori'          => 'Data Science',
                'short_description' => 'Visualisasi metrik S-Curve dan estimasi man-days tim pengembang.',
                'deskripsi'         => 'Dashboard pemantauan progres sprint Agile Scrum untuk membandingkan rencana vs realisasi proyek perangkat lunak.',
                'project_date'      => '2026-10-28',
                'tautan'            => 'https://github.com/username/scrum-dashboard',
                'status'            => 'published',
                'techs'             => [$techLaravel->id, $techTailwind->id],
            ],
            [
                'judul'             => 'Prototipe Sistem E-Voting Kampus (Draft)',
                'category_id'       => $catWeb->id,
                'kategori'          => 'Web Application',
                'short_description' => 'Proyek berstatus draft untuk pengujian filter status di halaman Admin.',
                'deskripsi'         => 'Rancangan sistem pemungutan suara elektronik mahasiswa yang masih dalam tahap pengembangan internal.',
                'project_date'      => '2026-11-14',
                'tautan'            => 'https://github.com/username/evoting-draft',
                'status'            => 'draft',
                'techs'             => [$techLaravel->id, $techMysql->id],
            ],
        ];

        foreach ($samples as $item) {
            $techIds = $item['techs'];
            unset($item['techs']);

            $slug = Str::slug($item['judul']);
            $project = Project::updateOrCreate(
                ['slug' => $slug],
                array_merge($item, ['slug' => $slug])
            );

            $project->technologies()->sync($techIds);
        }
    }
}