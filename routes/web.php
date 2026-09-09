<?php

use App\Livewire\Feed;
use App\Livewire\Learn\LearnDetail;
use App\Livewire\Learn\LearnIndex;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('learn', LearnIndex::class)
    ->name('learn.index');

Route::get('learn/{slug}', LearnDetail::class)
    ->name('learn.show');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('feed', Feed::class)
    ->middleware(['auth'])
    ->name('feed');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';


