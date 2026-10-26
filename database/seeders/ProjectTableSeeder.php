<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectTableSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 15; $i++) {
            Project::create([
                'judul'     => 'Project Portofolio Ke-' . $i,
                'kategori'  => 'Web Development',
                'deskripsi' => 'Ini adalah deskripsi lengkap untuk project portofolio judul ke-' . $i . ' yang dibuat otomatis menggunakan Seeder.',
                'tautan'    => 'https://github.com/Andhikafarhan11/PPWWebPortofolio',
                'status'    => 'published', 
            ]);
        }
    }
}