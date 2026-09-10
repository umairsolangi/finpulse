<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeeklyActivityPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'week_start_date',
        'points',
    ];

    protected function casts(): array
    {
        return [
            'week_start_date' => 'immutable_date:Y-m-d',
            'points' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
