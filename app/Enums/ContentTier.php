<?php

namespace App\Enums;

enum ContentTier: string
{
    case FREE = 'free';
    case REGISTERED = 'registered';
    case PAID = 'paid';
}
