@extends('layouts.app')

@section('title', $project->judul)

@section('content')
<div class="container py-4">
    {{-- Notifikasi Sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif

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

        {{-- Thumbnail Utama Project --}}
        @if ($project->thumbnail)
            <div class="mb-4 text-center">
                <img src="{{ asset('storage/' . $project->thumbnail) }}" 
                     alt="{{ $project->judul }}" 
                     class="img-fluid rounded shadow-sm border" 
                     style="max-height: 400px; width: auto; object-fit: cover;">
            </div>
        @endif

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

        {{-- ================= BAGIAN GALLERY PROJECT ================= --}}
        <div class="gallery-section my-4">
            <h4 class="fw-bold mb-3">Galeri Foto Project</h4>

            {{-- Form Upload Multiple Gambar Gallery --}}
            <form action="{{ route('projects.gallery.store', $project->id) }}" 
                  method="POST" 
                  enctype="multipart/form-data" 
                  class="p-3 border rounded bg-light mb-4">
                @csrf
                <label class="form-label fw-semibold">Tambah Foto Galeri (Pilih hingga 10 gambar sekaligus):</label>
                <div class="input-group">
                    <input type="file" 
                           name="images[]" 
                           multiple 
                           accept="image/*" 
                           class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror" 
                           required>
                    <button type="submit" class="btn btn-primary">Upload Foto</button>
                </div>
                @error('images') 
                    <small class="text-danger d-block mt-1">{{ $message }}</small> 
                @enderror
                @error('images.*') 
                    <small class="text-danger d-block mt-1">{{ $message }}</small> 
                @enderror
            </form>

            {{-- Grid Menampilkan Gambar Gallery --}}
            @if ($project->images && $project->images->count() > 0)
                <div class="row g-3">
                    @foreach ($project->images as $img)
                        <div class="col-6 col-md-4 col-lg-3 text-center">
                            <div class="card h-100 shadow-sm border p-2">
                                <img src="{{ asset('storage/' . $img->image) }}" 
                                     alt="{{ $img->caption ?? $project->judul }}" 
                                     class="rounded mb-2" 
                                     style="height: 160px; object-fit: cover; width: 100%;">
                                
                                <form action="{{ route('projects.gallery.destroy', [$project->id, $img->id]) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Hapus gambar ini dari galeri?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted fst-italic">Belum ada foto galeri untuk project ini.</p>
            @endif
        </div>
        {{-- ========================================================== --}}

        <hr style="border: 0; border-top: 1px solid #e5e7eb; margin-bottom: 20px;">

        {{-- Tombol Aksi --}}
        <div class="action-buttons d-flex gap-2">
            <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning">
                Edit Project
            </a>

            <form action="{{ route('projects.destroy', $project->id) }}" 
                  method="POST" 
                  onsubmit="return confirm('Apakah Anda yakin ingin memindahkan project ini ke sampah?');">
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