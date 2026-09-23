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

    <form action="{{ route('projects.update', $project->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Judul Project</label>
            <input type="text" 
                   class="form-control @error('title') is-invalid @enderror" 
                   id="title" 
                   name="title" 
                   value="{{ old('title', $project->title) }}" 
                   required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Kategori / Teknologi</label>
            <input type="text" 
                   class="form-control @error('category') is-invalid @enderror" 
                   id="category" 
                   name="category" 
                   value="{{ old('category', $project->kategori) }}">
            @error('category')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="link" class="form-label">Link Project / GitHub (Opsional)</label>
            <input type="text" 
                   class="form-control @error('link') is-invalid @enderror" 
                   id="link" 
                   name="link" 
                   value="{{ old('link', $project->link) }}">
            @error('link')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi Project</label>
            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                      id="description" 
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