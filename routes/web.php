<?php

use App\Http\Controllers\BrokerageReferralController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\SafepayCallbackController;
use App\Http\Controllers\SafepayWebhookController;
use App\Livewire\Admin\RoleChanges\Index as AdminRoleChangesIndex;
use App\Livewire\Admin\Roles\Index as AdminRolesIndex;
use App\Livewire\Admin\Settings\Index as AdminSettingsIndex;
use App\Livewire\Admin\Users\Index as AdminUsersIndex;
use App\Livewire\Admin\Users\Show as AdminUsersShow;
use App\Livewire\Course\ChapterViewer;
use App\Livewire\Course\CourseDetail;
use App\Livewire\Course\CourseIndex;
use App\Livewire\Feed;
use App\Livewire\Leaderboard;
use App\Livewire\Learn\LearnDetail;
use App\Livewire\Learn\LearnIndex;
use App\Livewire\LiveSessions\LiveSessionCreate;
use App\Livewire\LiveSessions\LiveSessionIndex;
use App\Livewire\Onboarding;
use App\Livewire\Pricing;
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

// Phase 3 — Subscriptions & Payments
Route::get('pricing', Pricing::class)
    ->name('pricing');

Route::post('webhooks/safepay', [SafepayWebhookController::class, 'handle'])
    ->name('webhooks.safepay');

Route::get('checkout/success', [SafepayCallbackController::class, 'success'])
    ->name('checkout.success');

Route::get('checkout/cancel', [SafepayCallbackController::class, 'cancel'])
    ->name('checkout.cancel');

// Phase 3 — Live Sessions
Route::get('live-sessions', LiveSessionIndex::class)
    ->name('live-sessions.index');

Route::get('live-sessions/create', LiveSessionCreate::class)
    ->middleware(['auth'])
    ->name('live-sessions.create');

// Phase 3 — Brokerage Referral
Route::get('referral/brokerage', [BrokerageReferralController::class, 'redirect'])
    ->name('referral.brokerage');

// Legal & Compliance Pages
Route::view('terms', 'legal.terms')->name('terms');
Route::view('privacy', 'legal.privacy')->name('privacy');
Route::view('refund-policy', 'legal.refund')->name('refund-policy');

// Phase 4 — Admin Panel & Role Management
Route::prefix('admin')->name('admin.')->middleware(['auth', 'permission:users.manage'])->group(function () {
    Route::get('users', AdminUsersIndex::class)->name('users.index');
    Route::get('users/{id}', AdminUsersShow::class)->name('users.show');
    Route::get('roles', AdminRolesIndex::class)->name('roles.index');
    Route::get('role-changes', AdminRoleChangesIndex::class)->name('role-changes.index');
    Route::get('settings', AdminSettingsIndex::class)->middleware('permission:settings.manage')->name('settings.index');
});

require __DIR__.'/auth.php';
