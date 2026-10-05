<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewPostController;
use App\Http\Controllers\ProjectController; 

Route::get('/', fn() => view('home'))->name('home');
Route::get('/about', fn() => view('about'))->name('about');
Route::get('/education', fn() => view('education'))->name('education');

Route::get('/projects/trash', [ProjectController::class, 'trash'])->name('projects.trash');
Route::post('/projects/{id}/restore', [ProjectController::class, 'restore'])->name('projects.restore');
Route::delete('/projects/{id}/force-delete', [ProjectController::class, 'forceDelete'])->name('projects.forceDelete');

Route::resource('projects', ProjectController::class); 
Route::resource('new-posts', NewPostController::class);