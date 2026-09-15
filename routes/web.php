<?php

use App\Http\Controllers\CertificateController;
use App\Livewire\Course\ChapterViewer;
use App\Livewire\Course\CourseDetail;
use App\Livewire\Course\CourseIndex;
use App\Livewire\Feed;
use App\Livewire\Leaderboard;
use App\Livewire\Learn\LearnDetail;
use App\Livewire\Learn\LearnIndex;
use App\Livewire\Onboarding;
use App\Livewire\Research\ResearchCreate;
use App\Livewire\Research\ResearchDetail;
use App\Livewire\Research\ResearchIndex;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('learn', LearnIndex::class)
    ->name('learn.index');

Route::get('learn/{slug}', LearnDetail::class)
    ->name('learn.show');

Route::get('courses', CourseIndex::class)
    ->name('courses.index');

Route::get('courses/{slug}', CourseDetail::class)
    ->name('courses.show');

Route::get('courses/{slug}/chapters/{chapterId}', ChapterViewer::class)
    ->name('courses.chapter');

Route::get('certificates/{id}/download', [CertificateController::class, 'download'])
    ->middleware(['auth'])
    ->name('certificates.download');

Route::get('research', ResearchIndex::class)
    ->name('research.index');

Route::get('research/create', ResearchCreate::class)
    ->middleware(['auth', 'can:content.publish'])
    ->name('research.create');

Route::get('research/{slug}', ResearchDetail::class)
    ->name('research.show');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('feed', Feed::class)
    ->middleware(['auth'])
    ->name('feed');

Route::get('leaderboard', Leaderboard::class)
    ->middleware(['auth'])
    ->name('leaderboard');

Route::get('onboarding', Onboarding::class)
    ->middleware(['auth'])
    ->name('onboarding');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
