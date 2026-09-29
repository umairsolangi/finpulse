<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoginStreak extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'login_date',
        'current_streak',
        'longest_streak',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'login_date' => 'date',
            'current_streak' => 'integer',
            'longest_streak' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
