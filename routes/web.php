<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectGalleryController;

// 1. Rute Publik
Route::get('/', fn() => view('home'))->name('home');
Route::get('/home', fn() => redirect()->route('home'));
Route::get('/about', fn() => view('about'))->name('about');
Route::get('/education', fn() => view('education'))->name('education');

// Rute Dashboard bawaan Breeze (Otomatis diarahkan ke /post/dashboard)
Route::get('/dashboard', function () {
    return redirect()->route('post.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 2. Rute Khusus Semua User yang Sudah Login (Auth)
Route::middleware('auth')->group(function () {
    // Rute Grup /post (Dashboard & Profile Saya)
    Route::prefix('post')->name('post.')->group(function () {
        // Materi Pertemuan 10: Halaman /post/dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Halaman /post/profile-saya khusus user login
        Route::get('/profile-saya', function () {
            return view('profile-saya');
        })->name('profile.saya');
    });

    // Rute Bawaan Profile Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 3. Rute Khusus Admin (Dilindungi Middleware 'auth' dan 'admin' / EnsureAdmin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/projects/trash', [ProjectController::class, 'trash'])->name('projects.trash');
    Route::post('/projects/{id}/restore', [ProjectController::class, 'restore'])->name('projects.restore');
    Route::delete('/projects/{id}/force-delete', [ProjectController::class, 'forceDelete'])->name('projects.forceDelete');

    Route::resource('projects', ProjectController::class);

    // Materi Pertemuan 10: Rute Upload & Hapus Gambar Gallery
    Route::post('/projects/{project}/gallery', [ProjectGalleryController::class, 'store'])->name('projects.gallery.store');
    Route::delete('/projects/{project}/gallery/{image}', [ProjectGalleryController::class, 'destroy'])->name('projects.gallery.destroy');
});

require __DIR__.'/auth.php';