<?php

namespace App\Models;

use App\Enums\RoleChangeAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoleChangeLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'target_user_id',
        'changed_by_user_id',
        'action',
        'role',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'action' => RoleChangeAction::class,
            'created_at' => 'datetime',
        ];
    }

    public function targetUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    public function changedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by_user_id');
    }
}
