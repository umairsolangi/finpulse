<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password', 'activity_score', 'onboarded_at', 'last_login_at', 'brokerage_referral_clicked_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'activity_score' => 'integer',
            'onboarded_at' => 'datetime',
            'brokerage_referral_clicked_at' => 'datetime',
        ];
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function createdContentItems(): HasMany
    {
        return $this->hasMany(ContentItem::class, 'created_by');
    }

    public function createdCourses(): HasMany
    {
        return $this->hasMany(Course::class, 'created_by');
    }

    public function courseProgress(): HasMany
    {
        return $this->hasMany(CourseProgress::class, 'user_id');
    }

    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
            ->withPivot('earned_at')
            ->withTimestamps();
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(Reaction::class, 'user_id');
    }

    public function contentViews(): HasMany
    {
        return $this->hasMany(ContentView::class, 'user_id');
    }

    public function weeklyActivityPoints(): HasMany
    {
        return $this->hasMany(WeeklyActivityPoint::class, 'user_id');
    }

    public function interests(): HasMany
    {
        return $this->hasMany(UserInterest::class, 'user_id');
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class, 'user_id')->latest('issued_at');
    }

    public function quizAttempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class, 'user_id')->latest();
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'user_id')->latest();
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'user_id')->latest();
    }

    public function liveSessionBookings(): HasMany
    {
        return $this->hasMany(LiveSessionBooking::class, 'user_id');
    }

    public function hostedLiveSessions(): HasMany
    {
        return $this->hasMany(LiveSession::class, 'host_id');
    }

    /**
     * Check if the user has an active, unexpired subscription.
     */
    public function hasActiveSubscription(): bool
    {
        return $this->subscriptions()
            ->whereIn('status', ['active', 'cancelled'])
            ->where('ends_at', '>', now())
            ->exists();
    }

    /**
     * Get current active subscription instance if any.
     */
    public function activeSubscription(): ?Subscription
    {
        return $this->subscriptions()
            ->whereIn('status', ['active', 'cancelled'])
            ->where('ends_at', '>', now())
            ->latest('ends_at')
            ->first();
    }

    /**
     * Determine if user has full paid tier access (active subscription or privileged role).
     */
    public function hasPaidAccess(): bool
    {
        if ($this->hasActiveSubscription()) {
            return true;
        }

        return $this->hasRole(['Paid Subscriber', 'Instructor', 'Admin']);
    }
}
