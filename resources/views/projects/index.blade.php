@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Project Portofolio</h2>
        <a href="{{ route('projects.create') }}" class="btn btn-primary">+ Tambah Project</a>
    </div>

    @if(count($projects) > 0)
        <div class="row">
            @foreach ($projects as $project)
                <div class="col-md-6 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <!-- Panggil Kategori -->
                            <span class="badge bg-secondary mb-2">{{ $project->kategori ?? 'Umum' }}</span>
                            
                            <!-- Panggil Judul (bisa diklik menuju halaman detail) -->
                            <h4 class="card-title">
                                <a href="{{ route('projects.show', $project->id) }}" class="text-decoration-none">
                                    {{ $project->judul }}
                                </a>
                            </h4>
                            
                            <!-- Panggil Deskripsi Singkat -->
                            <p class="card-text text-muted">
                                {{ Str::limit($project->deskripsi, 100) }}
                            </p>

                            <!-- Panggil Tautan (jika ada isinya) -->
                            @if($project->tautan)
                                <a href="{{ $project->tautan }}" target="_blank" class="btn btn-sm btn-outline-info">Buka Link</a>
                            @endif

                            <a href="{{ route('projects.show', $project->id) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
                        </div>
                        <div class="card-footer text-muted small">
                            Dibuat: {{ $project->created_at }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">Belum ada data project.</div>
    @endif
</div>
@endsection