<?php

namespace App\Enums;

enum RoleChangeAction: string
{
    case ASSIGNED = 'assigned';
    case REMOVED = 'removed';
}
