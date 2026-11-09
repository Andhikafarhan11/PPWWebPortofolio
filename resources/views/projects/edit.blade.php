@extends('layouts.app')

@section('title', 'Edit Project')

@section('content')
<div class="container py-4">
    <h2>Edit Data Project Portofolio</h2>
    <hr>

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Penambahan enctype="multipart/form-data" --}}
    <form action="{{ route('projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="judul" class="form-label">Judul Project</label>
            <input type="text" 
                   class="form-control @error('judul') is-invalid @enderror" 
                   id="judul" 
                   name="judul" 
                   value="{{ old('judul', $project->judul ?? $project->title) }}" 
                   required>
            @error('judul')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Input Thumbnail & Pratinjau File Lama --}}
        <div class="mb-3">
            <label for="thumbnail" class="form-label">Thumbnail Project (Kosongkan jika tidak ingin mengubah)</label>
            
            @if ($project->thumbnail)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $project->thumbnail) }}" 
                         alt="{{ $project->judul ?? 'Thumbnail' }}" 
                         class="img-thumbnail" 
                         style="max-height: 150px; display: block;">
                    <small class="text-muted">Thumbnail saat ini</small>
                </div>
            @endif

            <input type="file" 
                   class="form-control @error('thumbnail') is-invalid @enderror" 
                   id="thumbnail" 
                   name="thumbnail" 
                   accept="image/*">
            @error('thumbnail')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori / Teknologi</label>
            <input type="text" 
                   class="form-control @error('kategori') is-invalid @enderror" 
                   id="kategori" 
                   name="kategori" 
                   value="{{ old('kategori', $project->kategori ?? $project->category) }}">
            @error('kategori')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tautan" class="form-label">Link Project / GitHub (Opsional)</label>
            <input type="text" 
                   class="form-control @error('tautan') is-invalid @enderror" 
                   id="tautan" 
                   name="tautan" 
                   value="{{ old('tautan', $project->tautan ?? $project->link) }}">
            @error('tautan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi Project</label>
            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                      id="deskripsi" 
                      name="deskripsi" 
                      rows="5" 
                      required>{{ old('deskripsi', $project->deskripsi) }}</textarea>
            @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="action-buttons">
            <button type="submit" class="btn btn-warning">Update Project</button>
            <a href="{{ route('projects.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection