<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewPostController;
use App\Http\Controllers\ProjectController; 


Route::get('/', fn() => view('home'))->name('home');
Route::get('/about', fn() => view('about'))->name('about');
Route::get('/education', fn() => view('education'))->name('education');
Route::get('/projects', fn() => view('projects'))->name('projects');

Route::resource('new-posts', NewPostController::class);
Route::resource('projects', ProjectController::class);