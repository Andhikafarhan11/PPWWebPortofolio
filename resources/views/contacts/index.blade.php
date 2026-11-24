@extends('layouts.app')

@section('title', 'Daftar Pesan Masuk (Admin Contacts)')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Pesan Masuk (Messages)</h2>
        <a href="{{ route('post.dashboard') }}" class="btn btn-outline-secondary btn-sm">Ke Dashboard</a>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Nama Pengirim</th>
                            <th>Email</th>
                            <th>Subjek</th>
                            <th>Waktu Kirim</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($contacts as $key => $contact)
                            <tr class="{{ !$contact->is_read ? 'fw-semibold bg-light' : '' }}">
                                <td class="ps-4">{{ $contacts->firstItem() + $key }}</td>
                                <td>{{ $contact->name }}</td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ $contact->subject ?? '(Tanpa Subjek)' }}</td>
                                <td class="text-muted small">
                                    {{ $contact->created_at->format('d M Y, H:i') }}
                                    <span class="d-block text-secondary">{{ $contact->created_at->diffForHumans() }}</span>
                                </td>
                                <td>
                                    @if ($contact->is_read)
                                        <span class="badge bg-success-subtle text-success px-2 py-1">Sudah dibaca</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger px-2 py-1">Belum dibaca</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('post.contacts.show', $contact->id) }}" class="btn btn-sm btn-primary">
                                        Buka Pesan
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    Belum ada pesan masuk dari halaman Contact.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3 d-flex justify-content-center">
        {{ $contacts->links() }}
    </div>
</div>
@endsection