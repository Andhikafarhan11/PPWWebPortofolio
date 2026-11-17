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

    {{-- Panel Search, Filter (Category, Technology, Status), Sorting, & Per Halaman --}}
    <div class="card shadow-sm border-0 rounded-3 mb-4 bg-light">
        <div class="card-body p-3">
            <form action="{{ route('projects.index') }}" method="GET">
                <div class="row g-2 align-items-center">
                    {{-- 1. Input Search --}}
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Cari judul / deskripsi..." 
                               value="{{ request('search') }}">
                    </div>

                    {{-- 2. Dropdown Filter Kategori --}}
                    <div class="col-md-2">
                        <select name="category" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $c)
                                <option value="{{ $c->slug }}" @selected(request('category') === $c->slug)>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 3. LATIHAN 1: Dropdown Filter Technology --}}
                    <div class="col-md-2">
                        <select name="technology" class="form-select">
                            <option value="">Semua Teknologi</option>
                            @foreach ($technologies as $tech)
                                <option value="{{ $tech->slug }}" @selected(request('technology') === $tech->slug)>
                                    {{ $tech->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 4. LATIHAN 4: Dropdown Filter Status Admin --}}
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="published" @selected(request('status') === 'published')>Published</option>
                            <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                        </select>
                    </div>

                    {{-- 5. LATIHAN 2: Dropdown Sorting (Termasuk project_date) --}}
                    <div class="col-md-2">
                        <select name="sort" class="form-select">
                            <option value="terbaru" @selected(request('sort') === 'terbaru' || !request('sort'))>Input Terbaru</option>
                            <option value="terlama" @selected(request('sort') === 'terlama')>Input Terlama</option>
                            <option value="az" @selected(request('sort') === 'az')>Judul (A-Z)</option>
                            <option value="tanggal_terbaru" @selected(request('sort') === 'tanggal_terbaru')>Tanggal Project (Terbaru)</option>
                            <option value="tanggal_terlama" @selected(request('sort') === 'tanggal_terlama')>Tanggal Project (Terlama)</option>
                        </select>
                    </div>

                    {{-- Tombol Cari / Filter --}}
                    <div class="col-md-1 d-grid">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </div>

                {{-- Baris Bawah: LATIHAN 3 ('N hasil ditemukan', Tombol Reset) & Dropdown Per Halaman --}}
                <div class="d-flex flex-wrap justify-content-between align-items-center mt-3 pt-2 border-top">
                    <div class="d-flex align-items-center gap-3">
                        <span class="text-muted small">
                            <strong>{{ $projects->total() }}</strong> hasil ditemukan
                        </span>

                        @if(request()->anyFilled(['search', 'category', 'technology', 'status', 'sort']))
                            <a href="{{ route('projects.index', ['per_page' => request('per_page')]) }}" class="btn btn-sm btn-outline-danger">
                                Reset Filter
                            </a>
                        @endif
                    </div>

                    <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
                        <label for="per_page" class="small text-muted text-nowrap mb-0">Tampilkan:</label>
                        <select name="per_page" id="per_page" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit();">
                            <option value="5" @selected(request('per_page') == 5)>5 data per halaman</option>
                            <option value="9" @selected(request('per_page') == 9)>9 data per halaman</option>
                            <option value="10" @selected(request('per_page', 10) == 10)>10 data per halaman</option>
                            <option value="25" @selected(request('per_page') == 25)>25 data per halaman</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(count($projects) > 0)
        <div class="row">
            @foreach ($projects as $key => $project)
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
                                <div class="d-flex gap-2 flex-wrap">
                                    <span class="badge bg-secondary-subtle text-secondary px-2 py-1 rounded-2">
                                        {{ $project->category->name ?? ($project->kategori ?? 'General') }}
                                    </span>
                                    <span class="badge {{ $project->status === 'draft' ? 'bg-warning-subtle text-warning' : 'bg-success-subtle text-success' }} px-2 py-1 rounded-2">
                                        {{ $project->status ?? 'published' }}
                                    </span>
                                </div>

                                {{-- Indikator nomor urut berlanjut antarhalaman --}}
                                <span class="badge bg-light text-dark border fw-bold">
                                    #{{ $projects->firstItem() + $key }}
                                </span>
                            </div>

                            <h4 class="card-title fw-bold">
                                <a href="{{ route('projects.show', $project->id) }}" class="text-decoration-none text-dark">
                                    {{ $project->judul }}
                                </a>
                            </h4>
                            <p class="card-text text-muted flex-grow-1">
                                {{ $project->short_description ?? Str::limit($project->deskripsi, 110) }}
                            </p>

                            {{-- Baris Badge Technologies (Relasi Many-to-Many) --}}
                            @if ($project->technologies && $project->technologies->count() > 0)
                                <div class="mb-3 d-flex flex-wrap gap-1">
                                    @foreach ($project->technologies as $tech)
                                        <span class="badge bg-dark-subtle text-dark border px-2 py-1" style="font-size: 0.75rem;">
                                            {{ $tech->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                            
                            {{-- Baris Tombol Aksi Cepat --}}
                            <div class="action-buttons mt-2 d-flex gap-2">
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
                        <div class="card-footer text-muted small bg-white border-top-0 d-flex justify-content-between">
                            <span>Dibuat: {{ $project->created_at->format('d M Y') }}</span>
                            <span>Tanggal Project: {{ $project->project_date ? $project->project_date->format('d M Y') : '-' }}</span>
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
        {{-- Indikator Berhasil: Pesan kosong tampil saat tidak ada project yang cocok --}}
        <div class="alert alert-warning text-center py-4">
            <h5 class="fw-bold mb-1">Tidak ada project yang cocok.</h5>
            <p class="mb-2 text-muted small">
                @if(request('search'))
                    Tidak ditemukan project dengan kata kunci "<strong>{{ request('search') }}</strong>".
                @else
                    Tidak ada project yang sesuai dengan kombinasi filter yang dipilih.
                @endif
            </p>
            <a href="{{ route('projects.index') }}" class="btn btn-sm btn-outline-dark">Reset Semua Filter</a>
        </div>
    @endif
</div>
@endsection