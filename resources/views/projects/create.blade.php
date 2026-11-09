@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Tambah Project Baru</h2>
    <hr>
    @if ($errors->any())
        <div style="background-color: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px;">
            <p style="font-weight: bold; margin-bottom: 8px;">Terdapat kesalahan pada pengisian form:</p>
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Penambahan enctype="multipart/form-data" --}}
    <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="judul" class="form-label">Judul Project</label>
            <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" required>
            @error('judul')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Input Thumbnail Baru --}}
        <div class="mb-3">
            <label for="thumbnail" class="form-label">Thumbnail Project (Min. 400x300, Maks. 2MB)</label>
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
            <input type="text" class="form-control @error('kategori') is-invalid @enderror" id="kategori" name="kategori" value="{{ old('kategori') }}">
            @error('kategori')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tautan" class="form-label">Tautan / Link Project</label>
            <input type="url" class="form-control @error('tautan') is-invalid @enderror" id="tautan" name="tautan" value="{{ old('tautan') }}" placeholder="https://...">
            @error('tautan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi Project</label>
            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan Project</button>
        <a href="{{ route('projects.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection