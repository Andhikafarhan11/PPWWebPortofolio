@extends('layouts.app')

@section('title', 'Daftar Project Portofolio')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Project Portofolio</h2>
        <a href="{{ route('projects.create') }}" class="btn btn-success">+ Tambah Project Baru</a>
    </div>

    {{-- Penampil Pesan Flash Notifikasi --}}
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 6px; margin-bottom: 16px;">
        {{ session('success') }}
    </div>
    @endif

    @if(count($projects) > 0)
        <div class="row">
            @foreach ($projects as $project)
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body d-flex flex-column">
                            <span class="badge bg-secondary align-self-start mb-2">{{ $project->kategori ?? 'General' }}</span>
                            <h4 class="card-title">
                                <a href="{{ route('projects.show', $project->id) }}" class="text-decoration-none text-dark">
                                    {{ $project->judul }}
                                </a>
                            </h4>
                            <p class="card-text text-muted flex-grow-1">
                                {{ Str::limit($project->deskripsi, 110) }}
                            </p>
                            
                            {{-- Baris Tombol Aksi Cepat --}}
                            <div class="action-buttons mt-3">
                                <a href="{{ route('projects.show', $project->id) }}" class="btn btn-info">Detail</a>
                                <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning">Edit</a>
                                
                                <form action="{{ route('projects.destroy', $project->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus project ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                        <div class="card-footer text-muted small bg-white border-top-0">
                            Dibuat: {{ $project->created_at->format('d M Y') }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">Belum ada project yang ditambahkan. Silakan klik tombol Tambah Project Baru di atas.</div>
    @endif
</div>
@endsection