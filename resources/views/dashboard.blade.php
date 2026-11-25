<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 fw-semibold mb-0 text-dark">
                {{ __('Dashboard') }}
            </h2>
            <a href="{{ route('post.contacts.index') }}" class="btn btn-primary btn-sm">
                Lihat Pesan Masuk ({{ $unreadMessages }} Belum Dibaca)
            </a>
        </div>
    </x-slot>

    <div class="container py-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- 6 Stat Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <small class="text-muted text-uppercase fw-semibold">Projects</small>
                        <div class="fs-3 fw-bold text-primary mt-1">{{ $totalProjects }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <small class="text-muted text-uppercase fw-semibold">Categories</small>
                        <div class="fs-3 fw-bold text-success mt-1">{{ $totalCategories }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <small class="text-muted text-uppercase fw-semibold">Technologies</small>
                        <div class="fs-3 fw-bold text-info mt-1">{{ $totalTechnologies }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <small class="text-muted text-uppercase fw-semibold">Skills</small>
                        <div class="fs-3 fw-bold text-warning mt-1">{{ $totalSkills }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <small class="text-muted text-uppercase fw-semibold">Messages</small>
                        <div class="fs-3 fw-bold text-secondary mt-1">{{ $totalMessages }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <small class="text-muted text-uppercase fw-semibold">Unread</small>
                        <div class="fs-3 fw-bold text-danger mt-1">{{ $unreadMessages }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Widget Admin: Status Cache & Status Queue --}}
        <div class="row g-4 mb-4">
            {{-- Widget 1: Status Cache --}}
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title fw-semibold mb-0">Status Cache</h5>
                            <form action="{{ route('post.cache.clear') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Bersihkan Semua Cache
                                </button>
                            </form>
                        </div>

                        <ul class="list-group list-group-flush">
                            @foreach ($cacheStatus as $key => $info)
                                <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-medium">{{ $info['label'] }}</div>
                                        <small class="text-muted font-monospace">{{ $key }}</small>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        @if ($info['exists'])
                                            <span class="badge rounded-pill text-bg-success">Aktif (HIT)</span>
                                            <form action="{{ route('post.cache.clear') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="key" value="{{ $key }}">
                                                <button type="submit" class="btn btn-link btn-sm text-danger p-0 text-decoration-none">
                                                    Hapus
                                                </button>
                                            </form>
                                        @else
                                            <span class="badge rounded-pill text-bg-secondary">Kosong (MISS)</span>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Widget 2: Status Queue --}}
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-3">Status Queue (Antrean Job)</h5>

                        <div class="row g-3">
                            <div class="col-6">
                                <div class="p-3 rounded border border-warning bg-warning-subtle h-100">
                                    <small class="text-warning-emphasis text-uppercase fw-semibold">Job Pending</small>
                                    <div class="display-6 fw-bold text-warning-emphasis my-1">{{ $pendingJobs }}</div>
                                    <small class="text-warning-emphasis">Menunggu diproses worker (tabel jobs)</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded border border-danger bg-danger-subtle h-100">
                                    <small class="text-danger-emphasis text-uppercase fw-semibold">Job Failed</small>
                                    <div class="display-6 fw-bold text-danger my-1">{{ $failedJobs }}</div>
                                    <small class="text-danger-emphasis">Gagal diproses (tabel failed_jobs)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Daftar 5 Project Terbaru --}}
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-3">Project Terbaru</h5>

                @if ($latestProjects->isEmpty())
                    <p class="text-muted small mb-0">Belum ada project yang ditambahkan.</p>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach ($latestProjects as $project)
                            <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-medium">{{ $project->judul ?? $project->title }}</div>
                                    <small class="text-muted">
                                        Kategori: {{ $project->category->name ?? ($project->kategori ?? '-') }}
                                    </small>
                                </div>
                                <small class="text-muted">
                                    {{ $project->created_at ? $project->created_at->diffForHumans() : '' }}
                                </small>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>