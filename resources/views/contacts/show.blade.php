@extends('layouts.app')

@section('title', 'Detail Pesan Masuk')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-3">
                <a href="{{ route('post.contacts.index') }}" class="btn btn-sm btn-secondary">
                    &larr; Kembali ke Daftar Pesan
                </a>
            </div>

            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">{{ $contact->subject ?? '(Tanpa Subjek)' }}</h5>
                    @if ($contact->is_read)
                        <span class="badge bg-success-subtle text-success px-2 py-1">Sudah dibaca</span>
                    @else
                        <span class="badge bg-danger-subtle text-danger px-2 py-1">Belum dibaca</span>
                    @endif
                </div>

                <div class="card-body p-4">
                    <div class="mb-3 pb-3 border-bottom text-muted small">
                        <div><strong>Dari:</strong> {{ $contact->name }} ({{ $contact->email }})</div>
                        <div><strong>Waktu Diterima:</strong> {{ $contact->created_at->format('d F Y, H:i:s') }} ({{ $contact->created_at->diffForHumans() }})</div>
                    </div>

                    <div class="p-3 bg-light rounded-2" style="white-space: pre-line;">{{ $contact->message }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection