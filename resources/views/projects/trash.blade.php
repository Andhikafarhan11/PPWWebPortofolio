@extends('layouts.app')

@section('title', 'Sampah Project')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Sampah Project (Trash)</h2>
        <a href="{{ route('projects.index') }}" class="btn btn-secondary"> Kembali ke Daftar Project</a>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 6px; margin-bottom: 16px;">
        {{ session('success') }}
    </div>
    @endif

    @if(count($trashedProjects) > 0)
        <div class="row">
            @foreach ($trashedProjects as $project)
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm border-0 border-start border-danger border-4">
                        <div class="card-body d-flex flex-column">
                            <span class="badge bg-danger align-self-start mb-2">Terhapus</span>
                            <h4 class="card-title text-dark">{{ $project->judul }}</h4>
                            <p class="card-text text-muted flex-grow-1">
                                {{ Str::limit($project->deskripsi, 110) }}
                            </p>
                            
                            <div class="action-buttons mt-3 d-flex gap-2">
                                <form action="{{ route('projects.restore', $project->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Restore</button>
                                </form>

                                <form action="{{ route('projects.forceDelete', $project->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus project ini secara PERMANEN?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">Hapus Permanen</button>
                                </form>
                            </div>
                        </div>
                        <div class="card-footer text-muted small bg-white border-top-0">
                            Dihapus pada: {{ $project->deleted_at->format('d M Y H:i') }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">Sampah kosong. Tidak ada project yang dihapus sementara.</div>
    @endif
</div>
@endsection