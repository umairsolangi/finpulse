<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'issued_at',
        'certificate_number',
    ];

    protected function casts(): array
    {
        return [
            'issued_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public static function generateCertificateNumber(): string
    {
        $year = now()->format('Y');
        do {
            $number = sprintf('FP-%s-%06d', $year, random_int(100000, 999999));
        } while (static::where('certificate_number', $number)->exists());

        return $number;
    }
}
