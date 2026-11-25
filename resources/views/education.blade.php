@extends('layouts.app')

@section('title', 'Education - Portfolio')

@section('content')
    <h1>Riwayat Pendidikan</h1>
    @forelse ($educations as $edu)
        <div class="project-card">
            <h3>{{ $edu->institution }}</h3>
            <p><strong>{{ $edu->degree }}</strong> ({{ $edu->period }})</p>
            <p>{{ $edu->description }}</p>
        </div>
    @empty
        <p>Belum ada data pendidikan.</p>
    @endforelse

    <hr>

    <h1>Portofolio Project</h1>
    <p>Berikut adalah beberapa proyek pengembangan sistem web yang telah saya kerjakan:</p>

    <div class="project-card">
        <h3>1. Sistem Portofolio Web Berbasis Laravel</h3>
        <p>
            Aplikasi web portofolio interaktif yang dibangun menggunakan framework Laravel dengan konsep 
            Model-View-Controller (MVC), arsitektur Blade Templating, dan manajemen aset terintegrasi via Vite.
        </p>
        <p><strong>Teknologi:</strong> Laravel, PHP, Blade, CSS3, Git</p>
    </div>

    <div class="project-card">
        <h3>2. Aplikasi Manajemen Data & Penjualan (POS)</h3>
        <p>
            Sistem informasi manajemen berbasis web untuk mengelola inventaris barang, transaksi penjualan, 
            serta rekapitulasi laporan secara real-time dan terstruktur.
        </p>
        <p><strong>Teknologi:</strong> PHP, MySQL, Bootstrap, JavaScript</p>
    </div>
@endsection