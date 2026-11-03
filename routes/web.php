<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;

// 1. Rute Publik
Route::get('/', fn() => view('home'))->name('home');
Route::get('/home', fn() => redirect()->route('home'));
Route::get('/about', fn() => view('about'))->name('about');
Route::get('/education', fn() => view('education'))->name('education');

// Rute Dashboard bawaan Breeze
Route::get('/dashboard', function () {
    return redirect()->route('post.profile.saya');
})->middleware(['auth', 'verified'])->name('dashboard');

// 2. Rute Khusus Semua User yang Sudah Login (Auth)
Route::middleware('auth')->group(function () {
    // Latihan Poin 3: Halaman /post/profile-saya khusus user login
    Route::get('/post/profile-saya', function () {
        return view('profile-saya');
    })->name('post.profile.saya');

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
});

require __DIR__.'/auth.php';