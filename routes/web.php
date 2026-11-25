<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectGalleryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactAdminController;
use App\Http\Controllers\PortfolioController;

// 1. Rute Publik
Route::get('/', [PortfolioController::class, 'home'])->name('home');
Route::get('/home', fn() => redirect()->route('home'));
Route::get('/about', [PortfolioController::class, 'about'])->name('about');
Route::get('/education', [PortfolioController::class, 'education'])->name('education');

// Materi REST API & Rate Limiting: Rute Form Contact + Throttle (Maks 3x/menit)
Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:contact')
    ->name('contact.store');

// Rute Dashboard bawaan Breeze (Otomatis diarahkan ke /post/dashboard)
Route::get('/dashboard', function () {
    return redirect()->route('post.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 2. Rute Khusus Semua User yang Sudah Login (Auth)
Route::middleware('auth')->group(function () {
    // Rute Grup /post (Dashboard, Profile Saya, & Admin Contacts)
    Route::prefix('post')->name('post.')->group(function () {
        // Halaman /post/dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Halaman /post/profile-saya khusus user login
        Route::get('/profile-saya', function () {
            return view('profile-saya');
        })->name('profile.saya');

        Route::post('/cache/clear', [DashboardController::class, 'clearCache'])->name('cache.clear');
        // Rute Admin Contacts (Hanya untuk user dengan role admin)
        Route::get('/contacts', [ContactAdminController::class, 'index'])->name('contacts.index');
        Route::get('/contacts/{contact}', [ContactAdminController::class, 'show'])->name('contacts.show');
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

    // Rute Upload & Hapus Gambar Gallery
    Route::post('/projects/{project}/gallery', [ProjectGalleryController::class, 'store'])->name('projects.gallery.store');
    Route::delete('/projects/{project}/gallery/{image}', [ProjectGalleryController::class, 'destroy'])->name('projects.gallery.destroy');
});

require __DIR__.'/auth.php';