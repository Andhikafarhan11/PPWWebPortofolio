@extends('layouts.app')

@section('title', 'Daftar Project Portofolio')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Project Portofolio</h2>
        <div>
            <a href="{{ route('projects.trash') }}" class="btn btn-warning me-2">Lihat Sampah</a>
            <a href="{{ route('projects.create') }}" class="btn btn-success">+ Tambah Project Baru</a>
        </div>
    </div>

    {{-- Penampil Pesan Flash Notifikasi --}}
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 6px; margin-bottom: 16px;">
        {{ session('success') }}
    </div>
    @endif

    {{-- Baris Search Bar dan Dropdown Per Halaman (5, 10, 25) --}}
    <div class="row mb-4 align-items-center">
        {{-- Form Pencarian Judul --}}
        <div class="col-md-6 mb-2 mb-md-0">
            <form action="{{ route('projects.index') }}" method="GET" class="d-flex gap-2">
                @if(request('per_page'))
                    <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                @endif
                <input type="text" name="search" class="form-control" 
                       placeholder="Cari judul project..." 
                       value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
                @if(request('search'))
                    <a href="{{ route('projects.index', ['per_page' => request('per_page')]) }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </form>
        </div>

        {{-- Dropdown Pilihan Jumlah Data Per Halaman --}}
        <div class="col-md-6 d-flex justify-content-md-end align-items-center gap-2">
            <label for="per_page" class="small text-muted text-nowrap">Tampilkan:</label>
            <form action="{{ route('projects.index') }}" method="GET" id="perPageForm">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                <select name="per_page" id="per_page" class="form-select form-select-sm" onchange="document.getElementById('perPageForm').submit();">
                    <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5 data per halaman</option>
                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 data per halaman</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 data per halaman</option>
                </select>
            </form>
        </div>
    </div>

    @if(count($projects) > 0)
        <div class="row">
            @foreach ($projects as $key =>$project)
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden">
                        
                        {{-- Tampilan Gambar Thumbnail Project --}}
                        @if ($project->thumbnail)
                            <img src="{{ asset('storage/' . $project->thumbnail) }}" 
                                 alt="{{ $project->judul }}" 
                                 class="card-img-top" 
                                 style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center text-muted" style="height: 180px;">
                                <small>Tidak ada thumbnail</small>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column p-4">
                            {{-- Baris Badge Kategori, Status, dan Nomor Urut Berlanjut --}}
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex gap-2">
                                    <span class="badge bg-secondary-subtle text-secondary px-2 py-1 rounded-2">
                                        {{ $project->kategori ?? 'General' }}
                                    </span>
                                    <span class="badge bg-success-subtle text-success px-2 py-1 rounded-2">
                                        {{ $project->status ?? 'published' }}
                                    </span>
                                </div>

                                {{-- Indikator nomor urut berlanjut antarhalaman --}}
                                <span class="badge bg-light text-dark border fw-bold">
                                    #{{ $projects->firstItem() +$key }}
                                </span>
                            </div>

                            <h4 class="card-title fw-bold">
                                <a href="{{ route('projects.show', $project->id) }}" class="text-decoration-none text-dark">
                                    {{ $project->judul }}
                                </a>
                            </h4>
                            <p class="card-text text-muted flex-grow-1">
                                {{ Str::limit($project->deskripsi, 110) }}
                            </p>
                            
                            {{-- Baris Tombol Aksi Cepat --}}
                            <div class="action-buttons mt-3 d-flex gap-2">
                                <a href="{{ route('projects.show', $project->id) }}" class="btn btn-info text-white">Detail</a>
                                <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning text-white">Edit</a>
                                
                                <form action="{{ route('projects.destroy', $project->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin memindahkan project ini ke sampah?');">
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

        {{-- Informasi Halaman & Tombol Navigasi Pagination --}}
        <div class="mt-4 text-muted small">
            Halaman : {{ $projects->currentPage() }} <br>
            Jumlah Data : {{ $projects->total() }} <br>
            Data Per Halaman : {{ $projects->perPage() }}
        </div>

        <div class="mt-3 d-flex justify-content-center">
            {{ $projects->links() }}
        </div>
    @else
        <div class="alert alert-info">
            @if(request('search'))
                Tidak ditemukan project dengan kata kunci "<strong>{{ request('search') }}</strong>". <a href="{{ route('projects.index') }}" class="alert-link">Reset pencarian</a>.
            @else
                Belum ada project berstatus published. Silakan klik tombol Tambah Project Baru di atas.
            @endif
        </div>
    @endif
</div>
@endsection