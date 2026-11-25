@extends('layouts.app')

@section('title', 'About Me - Portfolio')

@section('content')
    <h1>Tentang Saya</h1>
    <p class="lead">
        Saya adalah seorang mahasiswa TRPL yang memiliki ketertarikan mendalam pada Full-Stack Web Development.
    </p>
    <p>
        Dalam setiap proses pengembangan perangkat lunak, saya selalu mengutamakan penulisan kode yang bersih, 
        skalabilitas sistem, serta penerapan praktik terbaik industri. Saya terbiasa memecahkan masalah 
        kompleks secara logis dan terus mengeksplorasi teknologi web terbaru.
    </p>

    <h3>Keahlian Utama</h3>
    <ul>
        <li><strong>Backend:</strong> PHP, Laravel Framework, RESTful API</li>
        <li><strong>Frontend:</strong> HTML5, CSS3, JavaScript, Blade Templating</li>
        <li><strong>Database:</strong> MySQL, Relational Database Design</li>
        <li><strong>Tools & Version Control:</strong> Git, GitHub, VS Code, Vite</li>
    </ul>

    <h3>Pengalaman</h3>
    @forelse ($experiences as $exp)
        <div class="project-card">
            <h4>{{ $exp->title }} — {{ $exp->company }}</h4>
            <p><small>{{ $exp->period }}</small></p>
            <p>{{ $exp->description }}</p>
        </div>
    @empty
        <p>Belum ada data pengalaman.</p>
    @endforelse
@endsection