@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Tambah Project Baru</h2>
    <hr>

    <form action="{{ route('projects.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="judul" class="form-label">Judul Project</label>
            <input type="text" class="form-control" id="judul" name="judul" required>
        </div>

        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori / Teknologi</label>
            <input type="text" class="form-control" id="kategori" name="kategori">
        </div>

        <div class="mb-3">
            <label for="tautan" class="form-label">Tautan / Link Project</label>
            <input type="url" class="form-control" id="tautan" name="tautan" placeholder="https://...">
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi Project</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Project</button>
        <a href="{{ route('projects.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection