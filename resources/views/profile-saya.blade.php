@extends('layouts.app')

@section('title', 'Profile Saya')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">Profile Saya</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3 border-bottom pb-2">
                        <small class="text-muted d-block">Nama Lengkap</small>
                        <span class="fw-semibold fs-5">{{ Auth::user()->name }}</span>
                    </div>
                    <div class="mb-3 border-bottom pb-2">
                        <small class="text-muted d-block">Alamat Email</small>
                        <span class="fw-semibold">{{ Auth::user()->email }}</span>
                    </div>
                    <div class="mb-3 border-bottom pb-2">
                        <small class="text-muted d-block">Role Akun</small>
                        <span class="badge {{ Auth::user()->role === 'admin' ? 'bg-success' : 'bg-secondary' }} text-uppercase">
                            {{ Auth::user()->role ?? 'user' }}
                        </span>
                    </div>
                    <div>
                        <small class="text-muted d-block">Terdaftar Sejak</small>
                        <span>{{ Auth::user()->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection