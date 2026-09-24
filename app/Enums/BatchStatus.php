<?php

namespace App\Enums;

enum BatchStatus: string
{
    case UPCOMING = 'upcoming';
    case ACTIVE = 'active';
    case COMPLETED = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::UPCOMING => 'Upcoming',
            self::ACTIVE => 'Active',
            self::COMPLETED => 'Completed',
        };
    }
}
