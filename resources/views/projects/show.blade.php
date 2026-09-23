@extends('layouts.app')

@section('title', $project->judul)

@section('content')
<div class="container py-4">
    <div style="background: #ffffff; padding: 24px; border-radius: 8px; border: 1px solid #e5e7eb;">
        
        {{-- Kategori --}}
        @if(!empty($project->kategori))
            <span style="background: #e2e8f0; color: #334155; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: 600;">
                {{ $project->kategori }}
            </span>
        @endif

        {{-- Judul Project --}}
        <h1 style="font-size: 1.8rem; font-weight: bold; margin-top: 10px; margin-bottom: 8px; color: #111827;">
            {{ $project->judul }}
        </h1>

        {{-- Info Tanggal --}}
        <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 20px;">
            Dibuat pada: {{ $project->created_at ? $project->created_at->format('d M Y, H:i') : '-' }} | 
            Terakhir diupdate: {{ $project->updated_at ? $project->updated_at->format('d M Y, H:i') : '-' }}
        </p>

        <hr style="border: 0; border-top: 1px solid #e5e7eb; margin-bottom: 20px;">

        {{-- Isi Deskripsi Lengkap --}}
        <div style="font-size: 1rem; line-height: 1.7; color: #374151; margin-bottom: 24px;">
            {!! nl2br(e($project->deskripsi)) !!}
        </div>

        {{-- Tautan Eksternal / Demo --}}
        @if(!empty($project->tautan))
            <div style="margin-bottom: 24px;">
                <strong>Tautan Demo / Repository:</strong><br>
                <a href="{{ $project->tautan }}" target="_blank" style="color: #2563eb; text-decoration: underline;">
                    {{ $project->tautan }} &rarr;
                </a>
            </div>
        @endif

        <hr style="border: 0; border-top: 1px solid #e5e7eb; margin-bottom: 20px;">

        {{-- Tombol Aksi --}}
        <div class="action-buttons">
            <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning">
                Edit Project
            </a>

            <form action="{{ route('projects.destroy', $project->id) }}" 
                  method="POST" 
                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus project ini secara permanen?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                  Hapus Project
            </button>
            </form>

            <a href="{{ route('projects.index') }}" class="btn btn-secondary">
                Kembali ke Daftar
            </a>
        </div>

    </div>
</div>
@endsection