@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm p-4">
        <!-- Panggil Kategori -->
        <div>
            <span class="badge bg-secondary">{{ $project->kategori ?? 'Umum' }}</span>
        </div>

        <!-- Panggil Judul -->
        <h1 class="mt-2">{{ $project->judul }}</h1>
        <small class="text-muted">Tanggal Dibuat: {{ $project->created_at }}</small>
        <hr>

        <!-- Panggil Deskripsi Lengkap -->
        <h5>Deskripsi:</h5>
        <p style="white-space: pre-line;">{{ $project->deskripsi }}</p>

        <!-- Panggil Tautan jika ada -->
        @if($project->tautan)
            <div class="mb-3">
                <strong>Tautan Project:</strong> 
                <a href="{{ $project->tautan }}" target="_blank">{{ $project->tautan }}</a>
            </div>
        @endif

        <div class="mt-4">
            <a href="{{ route('projects.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
        </div>
    </div>
</div>
@endsection